<?php

namespace App\Http\Controllers\ApplicantArea;

use App\Question;
use App\Interview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\InterviewAnswerFormRequest;
use App\Http\Resources\ApplicantArea\AnswerResource;
use App\Http\Resources\ApplicantArea\QuestionResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\ApplicantArea\InterviewResource;
use App\Http\Resources\ApplicantArea\InterviewWithJobResource;

class InterviewsController extends Controller
{
    /**
     * retrive all interviews for the current applicant
     * 
     * @param  \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Resources\Json\ResourceCollection 
     */
    public function index(Request $request): ResourceCollection
    {
        $user = $request->user();

        $interviews = Interview::with('job')->whereIsTheApplicant($user)->get();

        return InterviewWithJobResource::collection($interviews);
    }

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
     * Save an answer for the given question in the given interview
     * 
     * @param \App\Interview $interview
     * @param \App\Question $question
     * 
     * @return \App\Http\Resources\ApplicantArea\AnswerResource
     */
    public function answer(InterviewAnswerFormRequest $request, Interview $interview, Question $question) : AnswerResource {

    	$data = $request->validated();
    	
    	$data['question_id'] = $question->getKey();

    	$answer = $interview->answers()->create($data);

        return new AnswerResource($answer);
    }


    /**
     * Submit the given interview
     * 
     * @param  \App\Interview $interview
     * 
     * @return \App\Http\Resources\ApplicantArea\InterviewResource
     */
    public function submit(Interview $interview): InterviewResource
    {
        $interview->submit();

        return new InterviewResource($interview);
    }
}
