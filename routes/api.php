<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
/**
 * TEST 4 ROUTES
 * API endpoint that returns all question answers in a paginated JSON response
 */
Route::middleware('api')->get('/surveys','SurveyController@indexPaginated');


/**
 * TEST 5 ROUTES
 * API endpoint to update a question
 */
