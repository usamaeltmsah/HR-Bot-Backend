<?php

namespace App\Http\Controllers\RecruiterArea;

use App\Job;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\RecruiterArea\JobResource;
use App\Http\Requests\RecruiterArea\JobFormRequest;
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
     * 
     * @param \App\Http\Requests\RecruiterArea\JobFormRequest $request
     * 
     * @return \App\Http\Resources\RecruiterArea\JobResource
     */
    public function store(JobFormRequest $request) : JobResource
    {
        $data = $request->validated();

        $user = $request->user();

        $job = $user->jobs()->create($data);
        
        return new JobResource($job);
    }

    /**
     * update the given job
     * 
     * @param \App\Http\Requests\RecruiterArea\JobFormRequest   $request
     * @param \App\Job                                          $job
     * 
     * @return \App\Http\Resources\RecruiterArea\JobResource
     */
    public function update(JobFormRequest $request, Job $job) : JobResource
    {
        $data = $request->validated();

        $job->update($data);
        
        return new JobResource($job);
    }

    /**
     * Delete the given job
     * 
     * @param Job $job
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job) : Response
    {
        $job->delete();

        return response(null, 204);
    }
}
