<?php

namespace App\Http\Controllers\ApplicantArea;

use App\Question;
use App\Interview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use App\Http\Requests\InterviewAnswerFormRequest;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class InterviewsController extends Controller
{
	/**
     * Get all questions for the given jobs
     * 
     * @param \App\Interview $interview
     * 
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function questions(Request $request, Interview $interview) : ResourceCollection {
        return QuestionResource::collection($interview->questions);
    }

	/**
     * Get all questions for the given jobs
     * 
     * @param \App\Interview $interview
     * 
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function answer(InterviewAnswerFormRequest $request, Interview $interview, Question $question) : ResourceCollection {

    	$data = $request->validated();
    	
    	$data['question_id'] = $question->getKey();

    	$answer = $interview->answers()->create($data);

        return AnswerResource::collection($answer);
    }
}
