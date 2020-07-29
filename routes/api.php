<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
 * crud operations for skills
 * people who can access this link
 * - recruiter can retrieve all skills
 * - recruiter can create a new skill
 * - recruiter can Update/ Delete skills who created before
 */
Route::apiResource('/skills', 'SkillsController');
/**
 * crud operations for questions
 * people who can access this link
 * - recruiter can create a new question for a specific job
 * - recruiter can Update/ Delete/ retrieve a question who created before
 */
Route::apiResource('/questions', 'QuestionsController');
/**
 * crud operations for answers
 * people who can access this link
 * - recruiter can add a perfect answer for a question who added
 * - recruiter can Update/ Delete/ retrieve a perfect answer who created before
 * - applicant can just add his/her answer for a given question in the interview
 */
Route::apiResource('/answers', 'AnswerController');
/**
 * crud operations for jobs
 * people who can access this link
 * - recruiter can create a new job
 * - recruiter can Update/ Delete/ retrieve a job who created before
 */
Route::apiResource('/jobs', 'JobsController');
/**
 *  people who can access this link
 *  - the recruiter who created the job
 *  - any applicant didn't access this interview before
 */
Route::get('/jobs/{job}/questions', 'JobsController@getJobQuestions');
