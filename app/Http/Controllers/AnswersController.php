<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Interview;
use App\Job;
use App\Question;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    public function store(Request $request, Interview $interview, Question $question, Job $job){

        $answer = new Answer();
        $answer->body = $request->input('body');
        $answer->question_id = $question->id;
        $answer->interview_id = $interview->id;
        $answer->save();
    }
}
