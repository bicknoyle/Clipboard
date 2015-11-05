<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Survey;
use App\Question;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.survey.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3'
        ]);

        $survey = Survey::create($request->only(['name']));
        return redirect()
            ->route('admin.surveys.edit', ['id' => $survey->id])
            ->with('success', 'Survey created!')
        ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $survey = Survey::findOrFail($id);

        return view('admin.survey.edit', compact('survey'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|min:3'
        ]);

        $survey = Survey::findOrFail($id);
        $survey->update($request->only(['name']));
        return redirect()
            ->route('admin.surveys.edit', ['id' => $survey->id])
            ->with('success', 'Survey updated!')
        ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $survey = Survey::findOrFail($id);

        $survey->delete();

        return redirect()
            ->route('admin.index')
            ->with('success', 'Survey deleted!')
        ;
    }

    /**
     * Store a question attached to the survey
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function storeQuestion(Request $request, $id)
    {
        $survey = Survey::findOrFail($id);

        $this->validate($request, [
            'label'    => 'required',
            'field'    => 'required|unique:questions,field,NULL,id,survey_id,'.$survey->id,
            'type'     => 'required|in:text,checkbox,radio,select',
            'required' => 'boolean',
            'options'  => 'required_if:type,select|required_if:type,radio|empty_if:type,text|empty_if:type,checkbox'
        ], ['options.empty_if' => 'The :attribute field should be empty for this type.']);

        $question = new Question($request->only(['label', 'field', 'type']));

        if (!empty($request->input('options'))) {
            $question->options = preg_split('/ ?, ?/', $request->input('options'));
        }

        $rules = [];
        if ($request->input('rules.required')) {
            $rules[] = 'required';
        }

        if (count($rules)) {
            $question->rules = $rules;
        }

        $survey->addQuestion($question);

        return redirect()
            ->route('admin.surveys.edit', ['id' => $survey->id])
            ->with('success', 'Question added!')
        ;
    }

    /**
     * Delete a question attached to the survey
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $survey_id
     * @param  int $question_id
     * @return \Illuminate\Http\Response
     */
    public function destroyQuestion(Request $request, $survey_id, $question_id)
    {
        $survey = Survey::findOrFail($survey_id);
        $question = $survey->questions()->whereId($question_id)->firstOrFail();

        $question->delete();

        return redirect()
            ->route('admin.surveys.edit', ['id' => $survey->id])
            ->with('success', 'Question deleted!')
        ;
    }
}
