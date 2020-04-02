<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    function evalAnswer($answer)
    {
        $score = 0.0;
        /*
         *
         * ToDo: Receive score from evalModel, and save it in score variable
         *
         * */
        return $score;
    }
    function sendAnsEvalToDB($answer)
    {
        $score = $this->evalAnswer($answer);
        $answerObj = new Answer();
        $answerObj->saveAnswerRow($answer, $score);
    }
}
