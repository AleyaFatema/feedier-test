<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/**
 * TEST 1 ROUTES
 */
/* Questionnaire routes */
Route::get('/questionnaires/create', 'QuestionnaireController@create');
Route::post('/questionnaires', 'QuestionnaireController@store');
Route::get('/questionnaires/{questionnaire}', 'QuestionnaireController@show');
Route::get('/questionnaires/{questionnaire}/questions/create', 'QuestionController@create');

/* Question */
Route::post('/questionnaires/{questionnaire}/questions', 'QuestionController@store');
Route::get('/questionnaires/{questionnaire}/questions/{question}/edit', 'QuestionController@edit');
Route::patch('/questionnaires/{questionnaire}/questions/{question}', 'QuestionController@update');
Route::delete('/questionnaires/{questionnaire}/questions/{question}', 'QuestionController@destroy');

/* get all question answers of all questionnaires */
Route::get('/answers/list','QuestionnaireController@getAll')->name('answers');

/* Surveys */
Route::get('/surveys','SurveyController@index')->name('surveys');
Route::get('/surveys/{questionnaire}-{slug}','SurveyController@show');
Route::post('/surveys/{questionnaire}-{slug}','SurveyController@store');

/**
 * TEST 2 ROUTES
 * Schedule job: Email last 48 hours textarea type survey responses to admin
 * This route is for testing only
 * On server it will run cron job with "schedule:run"
 */
Route::get('/email', function() {
    dispatch(new \App\Jobs\NotifyAnswersToAdminJob());
});

/**
 * TEST 3 ROUTES
 * This route is created to check the query result.
 * There is a artisan command "answers:soft-delete" to do this work
 */
/*Route::get('/emptyAnswers', function() {
    // ------ Get empty answers from survey_responses table
    $emptyAnswers = App\SurveyResponse\SurveyResponse::whereNull('responses')
        ->where(function ($query) {
            $query->where('created_at', '>=', Carbon\Carbon::now()->subDays(1));// last 24 hours
            $query->whereNull('answer_id')->orWhere('answer_id', '=', 0);
        })
        ->orderBy('created_at', 'desc')
        ->orderBy('id', 'desc')
        ->get();
    return response()->json($emptyAnswers, 201);
});*/
