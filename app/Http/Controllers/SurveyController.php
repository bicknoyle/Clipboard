<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\SurveyRepository;
use App\Survey;

class SurveyController extends Controller
{
    protected $repository;

    public function __construct(SurveyRepository $repository)
    {
        $this->repository = $repository;
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
}
