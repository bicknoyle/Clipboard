<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Response;
use App\Survey;

class SurveyController extends Controller
{
    /**
     * Index of surveys
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $surveys = Survey::all();

        return view('survey.index', compact('surveys'));
    }

    /**
     * Show that survey is complete
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSurveyDone($id)
    {
        $survey = Survey::findOrFail($id);

        return view('survey.done', compact('survey'));
    }

    /**
     * Return surveys questions
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSurvey($id)
    {
        $survey = Survey::findOrFail($id);

        return view('survey.show', compact('survey'));
    }

    /**
     * Store survey response
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function postSurvey($id, Request $request)
    {
        $survey = Survey::findOrFail($id);

        $this->validate($request, $survey->rules());

        $response = new Response(['ip' => $request->ip()]);
        $survey->addResponse($response);
        $response->answerQuestions($survey->questions, collect($request->all()));

        return redirect()->action('SurveyController@getSurveyDone', ['id' => $survey->id]);
    }
}
