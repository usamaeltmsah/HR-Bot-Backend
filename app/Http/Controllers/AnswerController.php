<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;
use App\Question;
use App\Interview;
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

    public function addAnswerOfQuestionTODB(Request $request)
    {
        //to be  validated latter after adding the Question model
        $questionId=($request['question_id']);
        $recordofQuestionId=Question::find($questionId);
        if(is_null($recordofQuestionId)){
            return response()->json('questionId doesnt exist',404);
        }
        elseif (is_null(Interview::find($request['interview_id']))){
            # code...
            return response()->json('interview id doesnt exist',404);
        }
        $x=Answer::create($request->all());

        return response()->json($x,200);
    }

    public function getAnswerById($id)
    {
        $answer=Answer::find($id);
        if(is_null($answer))
        {
            return response()->json('the answer of this id not found',404);
        }
        return response()->json($answer,200);
    }
}
