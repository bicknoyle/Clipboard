<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Survey;

class SurveyController extends Controller
{
    /**
     * Return surveys questions
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSurveyQuestions($id)
    {
        $survey = Survey::with('questions')->findOrFail($id);

        return view('survey.questions', compact('survey'));
    }
}
