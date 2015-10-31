<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\SurveyRepository;
use App\Answer;
use App\Response;
use App\Survey;

class SurveyController extends Controller
{
    protected $repository;

    public function __construct(SurveyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Show that survey is complete
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSurveyDone($id)
    {
        $survey = $this->repository->findOrFail($id);

        return view('survey.done', compact('survey'));
    }

    /**
     * Return surveys questions
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSurveyQuestions($id)
    {
        $survey = $this->repository->findOrFail($id);

        return view('survey.questions', compact('survey'));
    }

    /**
     * Store survey response
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function postSurveyQuestions($id, Request $request)
    {
        $survey = $this->repository->findOrFail($id);

        $rules = $this->buildRules($survey->questions);

        $this->validate($request, $rules);

        $response = Response::create([
            'survey_id' => $survey->id,
            'ip'        => $request->ip(),
        ]);

        foreach ($survey->questions as $question) {
            $response->answers()->save(new Answer([
                'question_id' => $question->id,
                'value'       => $request->input($question->field, ''),
            ]));
        }

        return redirect()->action('SurveyController@getSurveyDone', ['id' => $survey->id]);
    }

    /**
     * Build rules from a collection of questions
     *
     * @param \Illuminate\Database\Eloquent\Collection $questions
     * @return array
     */
    protected function buildRules(Collection $questions)
    {
        $rules = [];

        foreach ($questions as $question) {
            $rules[$question->field] = empty($question->rules) ? '' : $question->rules;
        }

        return $rules;
    }
}
