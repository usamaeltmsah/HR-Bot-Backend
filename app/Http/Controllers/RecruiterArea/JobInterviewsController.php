<?php

namespace App\Http\Controllers\RecruiterArea;

use App\Job;
use App\Interview;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\RecruiterArea\InterviewResource;
use App\Http\Resources\RecruiterArea\InterviewReportResource;

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
        $interviews = $job->interviews()
                            ->with('applicant')
                            ->orderBy('score', 'desc')
                            ->paginate();

        return InterviewResource::collection($interviews);
    }

    /**
     * Show the details of the given interview
     * 
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Job                 $job
     * @param  \App\Interview           $interview
     * @return \App\Http\Resources\RecruiterArea\InterviewReportResource
     */
    public function show(Request $request, Job $job, Interview $interview): InterviewReportResource
    {
        $interview->load('answers.question', 'applicant');

        return new InterviewReportResource($interview);
    }
}
