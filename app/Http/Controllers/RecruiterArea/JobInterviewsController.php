<?php

namespace App\Http\Controllers\RecruiterArea;

use App\Job;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\RecruiterArea\InterviewResource;

class JobInterviewsController extends Controller {


    /**
     * list all Jobs
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function index(Request $request, Job $job) : ResourceCollection
    {
        $interviews = $job->interviews()->with('applicant')->paginate();

        return InterviewResource::collection($interviews);
    }
}
