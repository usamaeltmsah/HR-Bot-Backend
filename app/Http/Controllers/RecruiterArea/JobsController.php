<?php

namespace App\Http\Controllers\RecruiterArea;

use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Http\Resources\JobResource;
use App\Http\Resources\QuestionResource;
use App\Job;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\ResourceCollection;

class JobsController extends Controller {


    /**
     * list all Jobs
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function index() : ResourceCollection{
        $jobs = new Job();
        $jobs = $this->filter($jobs);
        $jobs = $jobs->orderBy('id', 'desc')->paginate();
        return JobResource::collection($jobs);
    }

    /** filtration on all retrieved data
     * title ==> if the request has parameter title with (key) value to search for
     * available ==> if the request has parameter available with "true" value
     * @param $jobs
     * @return an instance of Job Model
     */
    protected function filter($jobs){
        if(request()->has('title') && request()->get('title') != ''){
            $jobs = $jobs->where('title', 'like', '%' . request()->get('title') . '%');
        }

        if(request()->has('available') && request()->get('available') == 'true'){
            $jobs = $jobs->where('accept_interviews_until', '>', now() );
        }

        return $jobs;
    }

    /**
     * return a specific job by its id
     * @param Job $job
     * @return JobResource
     */
    public function show(Job $job) : JobResource{
        return new JobResource($job);
    }

    /**
     * store a new job
     * @param StoreJobRequest $request
     * @return JobResource
     */
    public function store(StoreJobRequest $request) : JobResource{
        $job = Job::create($request->validated());
        return new JobResource($job);
    }

    /**
     * update a specific job by its id
     * @param UpdateJobRequest $request
     * @param Job $job
     * @return JobResource
     */
    public function update(UpdateJobRequest $request, Job $job) : JobResource{
        $job->update($request->validated());
        return new JobResource($job);
    }

    /**
     * delete a specific job by its id
     * @param Job $job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job) : Response{
        $job->delete();
        return response(null, 204);
    }

    /**
     * @param Job $job
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getJobQuestions(Job $job) {
        $questions = $job->questions;
        return QuestionResource::collection($questions);
    }


}
