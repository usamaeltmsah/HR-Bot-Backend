<?php

namespace App\Http\Controllers\RecruiterArea;

use App\Job;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Http\Resources\RecruiterArea\JobResource;
use App\Http\Resources\QuestionResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class JobsController extends Controller {


    /**
     * list all Jobs
     * 
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function index(Request $request) : ResourceCollection
    {
        $user = $request->user();

        $query = Job::createdBy($user)
                    ->latest();

        $query = $this->applyIndexFilters($request, $query);

        $jobs = $query->paginate();

        return JobResource::collection($jobs);
    }

    /** 
     * filtration on all retrieved data
     * 
     * title ==> if the request has parameter title with (key) value to search for
     * 
     * @param $jobs
     * 
     * @return an instance of Job Model
     */
    protected function applyIndexFilters($request, $query)
    {

        $filters = $request->validate([
            'title' => ['nullable', 'string', 'min:1'],
        ]);

        if(isset($filters['title'])){
            $query = $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        return $query;
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
