<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin', 'AdminController@getIndex');
Route::resource('admin/surveys', 'Admin\SurveyController', [
	'only' => ['create', 'store', 'edit', 'update']
]);
Route::post('admin/surveys/{id}/questions', ['uses' => 'Admin\SurveyController@storeQuestion', 'as' => 'admin.surveys.questions.store']);
Route::delete('admin/surveys/{survey_id}/questions/{question_id}', ['uses' => 'Admin\SurveyController@deleteQuestion', 'as' => 'admin.surveys.questions.delete']);

Route::get('surveys', 'SurveyController@getIndex');
Route::get('surveys/{id}', 'SurveyController@getSurvey');
Route::post('surveys/{id}', 'SurveyController@postSurvey');
Route::get('surveys/{id}/done', 'SurveyController@getSurveyDone');