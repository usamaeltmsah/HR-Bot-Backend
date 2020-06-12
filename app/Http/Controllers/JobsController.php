<?php

namespace App\Http\Controllers;

use App\Job;
use Validator;
use Illuminate\Http\Request;

class JobsController extends BackEndController{

    /** inject the Job Model to deal with database */
    public function __construct(Job $model){
        parent::__construct($model);
    }


    /** filtration on all retrieved data
     * title ==> if the request has parameter title with (key) value to search for
     * available ==> if the request has parameter available with "true" value
     */
    protected function filter($rows){
        if(request()->has('title') && request()->get('title') != ''){
            $rows = $rows->where('title', 'like', '%' . request()->get('title') . '%');
        }

        if(request()->has('available') && request()->get('available') == 'true'){
            $rows = $rows->where('accept_interviews_until', '>', now() );
        }

        return $rows;
    }

    /** validation on the request to store a new Job */
    protected function storeValidator(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'desc' => ['required', 'string'],
            'accept_interviews_from' => ['required', 'date_format:Y-m-d H:i:s'],
            'accept_interviews_until' => ['required', 'date_format:Y-m-d H:i:s'],
            'interviews_duration' => ['required', 'date_format:Y-m-d H:i:s'],
            'recruiter_id' => ['required', 'integer']
        ]);
        return $validator;
    }

    /** validation on the request to update an existing Job */
    protected function updateValidator(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'desc' => ['required', 'string'],
            'accept_interviews_from' => ['required', 'date_format:Y-m-d H:i:s'],
            'accept_interviews_until' => ['required', 'date_format:Y-m-d H:i:s'],
            'interviews_duration' => ['required', 'date_format:Y-m-d H:i:s']
        ]);
        return $validator;
    }

}
