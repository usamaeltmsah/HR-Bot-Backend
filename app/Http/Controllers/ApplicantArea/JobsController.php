<?php

namespace App\Http\Controllers\ApplicantArea;

use App\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicantArea\InterviewResource;

class JobsController extends Controller
{
	/**
	 * Apply on the given job
	 * 
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Job     			$job
	 * @return \App\Http\Resources\InterviewResource
	 */
    public function apply(Request $request, Job $job): InterviewResource
    {
    	$interview = $job->interviews()->create([
    		'applicant_id' => $request->user()->getKey(),
    	]);

    	return new InterviewResource($interview);
    }
}
