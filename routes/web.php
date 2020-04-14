<?php

use Illuminate\Support\Facades\Route;

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
/**
 * JUST FOR TESTING,
 * YOU CAN REMOVE THEM.
 */
Route::get('ansEval/{answer}', 'AnswerController@sendAnsEvalToDB');

Route::get('event/test', function (){
    $ans = new \App\Answer();
    $ans->body = "THIS IS AN ANSWER";
    $ans->question_id = 4;
   return event(new App\Events\AnswerCreated($ans));
});