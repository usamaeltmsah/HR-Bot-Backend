<?php

namespace App\Http\Controllers\RecruiterArea;

use App\Answer;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecruiterArea\AnswerResource;
use App\Http\Requests\RecruiterArea\AnswerScoreFormRequest;

class AnswersController extends Controller
{
	/**
	 * Update the score of the given answer
	 * @param  \ App\Http\Requests\RecruiterArea\AnswerScoreFormRequest $request 
	 * @param  \App\Answer                 $answer  
	 * @return \App\Http\Resources\RecruiterArea\AnswerResource
	 */
    public function updateScore(AnswerScoreFormRequest $request, Answer $answer): AnswerResource
    {
    	$data = $request->validated();
    	$answer->score = $data['score'];
    	$answer->save();
    	return new AnswerResource($answer);
    }
}
