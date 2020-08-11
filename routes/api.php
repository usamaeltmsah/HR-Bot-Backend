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

Route::post('/register', 'Auth\RegisterController@register');
Route::post('/login', 'Auth\LoginController@login');
Route::middleware('auth:api')->post('/logout', 'Auth\LoginController@logout');

Route::get(config('hrbot.route.prefix.applicantarea'), 'UserInfoController@currentUser')
	->middleware('auth:applicant')
	->name('applicantarea.current_user');

Route::get(config('hrbot.route.prefix.adminarea'), 'UserInfoController@currentUser')
	->middleware('auth:admin')
	->name('adminarea.current_user');

Route::get(config('hrbot.route.prefix.recruiterarea'), 'UserInfoController@currentUser')
	->middleware('auth:recruiter')
	->name('recruiterarea.current_user');

Route::name('guestarea.')
	->namespace('GuestArea')
	->prefix(config('hrbot.route.prefix.guestarea'))
	->group(function () {
		Route::name('jobs.')
			->prefix('jobs')
			->group(function(){
				Route::get('/', 'JobsController@index')
					->name('index');
			});
	});

Route::name('adminarea.')
	->middleware('auth:admin')
	->namespace('AdminArea')
	->prefix(config('hrbot.route.prefix.adminarea'))
	->group(function () {
		Route::apiResource('skills', 'SkillsController');		
		Route::apiResource('skills.questions', 'QuestionsController')->shallow();
		Route::apiResource('questions.model_answers', 'ModelAnswersController')->shallow();
	});

Route::name('recruiterarea.')
	->middleware('auth:recruiter')
	->namespace('RecruiterArea')
	->prefix(config('hrbot.route.prefix.recruiterarea'))
	->group(function () {

		Route::name('jobs.')
			->prefix('jobs')
			->group(function(){
				Route::get('/', 'JobsController@index')
					->name('index');

				Route::post('/', 'JobsController@store')
					->name('store');

				Route::get('/{job}', 'JobsController@show')
					->name('show')
					->middleware('can:modify,job');

				Route::put('/{job}', 'JobsController@update')
					->name('update')
					->middleware('can:modify,job');

				Route::delete('/{job}', 'JobsController@destroy')
					->name('destroy')
					->middleware('can:modify,job');

				
				Route::get('{job}/interviews', 'JobInterviewsController@index')
					->name('interviews.index')
					->middleware('can:modify,job');

			});

		Route::name('interviews.')
			->prefix('interviews')
			->group(function() {
				Route::get('/{interview}', 'JobInterviewsController@show')
					->name('show')
					->middleware('can:access,interview');

				Route::put('/{interview}/status', 'JobInterviewsController@updateStatus')
					->name('status')
					->middleware('can:access,interview');
			});

		Route::put('answers/{answer}/score', 'AnswersController@updateScore')
			->name('answers.score.update')
			->middleware('can:modify,answer');

		Route::apiResource('skills', 'SkillsController')->only(['index', 'show']);

		Route::apiResource('skills.questions', 'QuestionsController')->shallow()->only(['index', 'show']);
	});

Route::name('applicantarea.')
	->middleware('auth:applicant')
	->namespace('ApplicantArea')
	->prefix(config('hrbot.route.prefix.applicantarea'))
	->group(function () {
		Route::name('jobs.')
			->prefix('jobs')
			->group(function(){
				Route::get('/', 'JobsController@index')
					->name('index');

				Route::post('{job}/apply', 'JobsController@apply')
					->name('apply')
					->middleware('can:apply,job');
			});

		Route::name('interviews.')
			->prefix('interviews')
			->group(function(){
				Route::get('/', 'InterviewsController@index')
					->name('index');

				Route::get('{interview}/questions', 'InterviewsController@questions')
					->name('questions.index')
					->middleware(['can:access,interview']);

				Route::post('{interview}/questions/{question}/answers', 'InterviewsController@answer')
					->name('questions.answer')
					->middleware(['can:access,interview', 'can:answer,interview,question']);

				Route::post('{interview}/submit', 'InterviewsController@submit')
					->name('submit')
					->middleware(['can:access,interview']);
			});
	});

/**
 * crud operations for skills
 * people who can access this link
 * - recruiter can create a new skill
 * - recruiter can Update/ Delete/ retrieve a skill who created before
 */
// Route::apiResource('/skills', 'SkillsController');
/**
 * crud operations for questions
 * people who can access this link
 * - recruiter can create a new question for a specific job
 * - recruiter can Update/ Delete/ retrieve a question who created before
 */
// Route::apiResource('/questions', 'QuestionsController');
/**
 * crud operations for answers
 * people who can access this link
 * - recruiter can add a perfect answer for a question who added
 * - recruiter can Update/ Delete/ retrieve a perfect answer who created before
 * - applicant can just add his/her answer for a given question in the interview
 */
// Route::apiResource('/answers', 'AnswerController');
/**
 * crud operations for jobs
 * people who can access this link
 * - recruiter can create a new job
 * - recruiter can Update/ Delete/ retrieve a job who created before
 */
// Route::apiResource('/jobs', 'JobsController');
/**
 *  people who can access this link
 *  - the recruiter who created the job
 *  - any applicant didn't access this interview before
 */
// Route::get('/jobs/{job}/questions', 'JobsController@getJobQuestions');
