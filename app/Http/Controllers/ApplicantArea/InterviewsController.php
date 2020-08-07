<?php

namespace App\Http\Controllers\ApplicantArea;

use App\Interview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

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
}
