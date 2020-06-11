<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use App\Job;
use Validator;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(){
        $jobs = Job::orderBy('id', 'desc')->get();
        $res = ApiHelper::createApiResponse(false, 200, 'there are no jobs', $jobs);
        return response()->json($res, 200);
    }

    public function show(Job $job)
    {
        $res = ApiHelper::createApiResponse(false, 200, 'there are no jobs', $job);
        return response()->json($res, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'                     => ['required', 'string'],
            'desc'                      => ['required', 'string'],
            'accept_interviews_from'    => ['required', 'date_format:Y-m-d H:i:s'],
            'accept_interviews_until'   => ['required', 'date_format:Y-m-d H:i:s'],
            'interviews_duration'       => ['required', 'date_format:Y-m-d H:i:s'],
            'recruiter_id'              => ['required', 'integer']
        ]);


        if($validator->fails()) {
            $res = ApiHelper::createApiResponse(true, 400, $validator->errors()->first(), null);
            return response()->json($res, 400);
        }else{
            try{
                Job::create($request->all());
                $res = ApiHelper::createApiResponse(false, 201, 'Job Added Successfully', null);
                return response()->json($res, 201);
            }catch (Exception $exc){
                $res = ApiHelper::createApiResponse(true, 400, $exc, null);
                return response()->json($res, 400);
            }

        }
    }

    public function update(Job $job, Request $request){
        try {
            $job->update($request->all());
            $res = ApiHelper::createApiResponse(false, 200, 'Job updated successfully', null);
            return response()->json($res, 200);
        }catch (Exception $exception){
            $res = ApiHelper::createApiResponse(true, 400, 'Job update failed', null);
            return response()->json($res, 400);
        }

    }

    public function destroy($id){
        dd('destroy');
    }
}
