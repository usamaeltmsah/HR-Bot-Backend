<?php

namespace App\Http\Controllers\GuestArea;

use App\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\GuestArea\JobResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class JobsController extends Controller
{
    /**
     * List all the jobs that the applican should see
     * 
     * @param  \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {

    	$query = Job::acceptingInterviews()->latest();

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
