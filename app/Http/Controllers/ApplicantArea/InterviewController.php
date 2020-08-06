<?php

namespace App\Http\Controllers\ApplicantArea;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateInterviewRequest;
use App\Http\Resources\InterviewResource;
use App\Interview;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function startInterview( CreateInterviewRequest $request){
        // create an object an interview
//        return $request->all();
        $interview = Interview::create($request->validated());
        return new InterviewResource($interview);
    }
}
