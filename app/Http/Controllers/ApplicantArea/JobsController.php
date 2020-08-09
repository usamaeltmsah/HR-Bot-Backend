<?php

namespace App\Http\Controllers\ApplicantArea;

use App\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\ApplicantArea\JobResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
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

    /**
     * List all the jobs that the applican should see
     * 
     * @param  \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
    	$user = $request->user();

    	$query = Job::acceptingInterviews()
    				->didntApplyBefore($user)
                    ->latest();

    	$query = $this->applyIndexFilters($request, $query);

		$jobs = $query->paginate();

    	return JobResource::collection($jobs);
    }

    /**
     * Apply the index function filters
     * 
     * @param  \Illuminate\Http\Request                     $request 
     * @param  \Illuminate\Database\Eloquent\Builder        $query
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applyIndexFilters(Request $request, Builder $query): Builder
    {
    	$filters = $request->validate([
    		'title' => ['nullable', 'string', 'min:1'],
    	]);

    	if(isset($filters['title'])){
            $query = $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        return $query;
    }
}
