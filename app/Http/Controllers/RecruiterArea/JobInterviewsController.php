<?php

namespace App\Http\Controllers\RecruiterArea;

use App\Job;
use App\Interview;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Events\InterviewStatusBecameNotSelected;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\RecruiterArea\InterviewResource;
use App\Http\Resources\RecruiterArea\InterviewReportResource;
use App\Http\Requests\RecruiterArea\InterviewStatusFormRequest;

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
     * @param  \App\Interview           $interview
     * 
     * @return \App\Http\Resources\RecruiterArea\InterviewReportResource
     */
    public function show(Request $request, Interview $interview): InterviewReportResource
    {
        $interview->load('answers.question', 'applicant');

        return new InterviewReportResource($interview);
    }

    /**
     * Update the interview status
     * 
     * @param  \App\Http\Requests\RecruiterArea\InterviewStatusFormRequest $request
     * @param  \App\Interview                  $interview 
     * @return \App\Http\Resources\RecruiterArea\InterviewReportResource
     */
    public function updateStatus(InterviewStatusFormRequest $request, Interview $interview): InterviewReportResource
    {
        $data = $request->validated();
        $interview->status = $data['status'];
        $interview->save();
        if ($interview->status === "not selected") {
            event(new InterviewStatusBecameNotSelected($interview));
        }
        return new InterviewReportResource($interview);
    }
}
