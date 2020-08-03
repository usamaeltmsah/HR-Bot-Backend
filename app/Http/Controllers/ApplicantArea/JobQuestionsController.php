<?php

namespace App\Http\Controllers\ApplicantArea;

use App\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class JobQuestionsController extends Controller {

    /**
     * Get all questions for the given jobs
     * 
     * @param Job $job
     * 
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function index(Request $request, Job $job) : ResourceCollection {
        return QuestionResource::collection($job->questions);
    }

}
