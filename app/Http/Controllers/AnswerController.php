<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AnswerController extends Controller
{
    /**
     * Evaluate the given Answer
     * @param string $answerBody
     * @return float $score
     */
    public static function evalAnswer($answerBody)
    {
//        $score = "GET(API)";

        $score = 5.0;
        /*
         *
         * ToDo: Receive score from evalModel, and save it in score variable
         *
         * */
        return $score;
    }
    // /**
    //  * Save the answer and its evaluation(score) in the database
    //  *
    //  * @param $answerObj
    //  * @return Redirect
    //  * @internal param Answer $answer
    //  */
    // public static function sendAnsEvalToDB($answerObj)
    // {
    //     $score = self::evalAnswer($answerObj->body);
    //     $ans = new Answer();
        
    //     $ans->score = $score;
    //     $ans->save();
        
    //     $ans->fill(['score' => $score])->save();

    //     /**
    //      * ToDo: There's are some missing foreign keys should be assigned to make it possible to save the answer.
    //      */
    //     // $ans->create([
    //     //     'score' => $score,
    //     //     'body' => $answerObj->body,
    //     //     'question_id' => $answerObj->question_id,
    //     // ]);
    //     return redirect('/');
    // }
}
