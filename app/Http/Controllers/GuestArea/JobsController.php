<?php

namespace App\Http\Controllers\GuestArea;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobResource;
use App\Job;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class JobsController extends Controller
{

    public function getAvailableJobs() : ResourceCollection{
        $jobs = new Job();
        $jobs = $this->filter($jobs);
        $jobs = $jobs->orderBy('id', 'desc')->where('accept_interviews_until', '>', now() )->paginate();
        return JobResource::collection($jobs);
    }

    protected function filter($jobs){
        if(request()->has('title') && request()->get('title') != ''){
            $jobs = $jobs->where('title', 'like', '%' . request()->get('title') . '%');
        }

        return $jobs;
    }

}
