<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use App\Job;
use Illuminate\Http\JsonResponse;
use Validator;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    public function index(){
        try{
            $rows = new Job();
            $rows = $this->filter($rows);
            $jobs = $rows->orderBy('id', 'desc')->paginate();
            $res = ApiHelper::createApiResponse(false, 200, 'there are no jobs', $jobs->items());
            $res['total'] = $jobs->total();
            $res['perPage'] = $jobs->perPage();
            $res['currentPage'] = $jobs->currentPage();
            return response()->json($res, 200);
        }catch (Exception $exception){
            return $this->throwDatabaseException($exception);
        }

    }

    public function show($id)
    {
        $job = Job::find($id);
        if($job){
            $res = ApiHelper::createApiResponse(false, 200, '', $job);
            return response()->json($res, 200);
        }else{
            $res = ApiHelper::createApiResponse(true, 400, 'Job Does Not Exist', null);
            return response()->json($res, 400);
        }

    }

    public function store(Request $request)
    {
        $validator = $this->storeValidation($request);

        if($validator->fails()) {
            $res = ApiHelper::createApiResponse(true, 400, $validator->errors()->first(), null);
            return response()->json($res, 400);
        }else{
            try{
                Job::create($request->all());
                $res = ApiHelper::createApiResponse(false, 201, 'Job Added Successfully', null);
                return response()->json($res, 201);
            }catch (Exception $exception){
                return $this->throwDatabaseException($exception);
            }

        }
    }

    public function update($id, Request $request){

        $job = Job::find($id);

        $validator = $this->updateValidation($request);

        if($job == null){
            $res = ApiHelper::createApiResponse(true, 400, 'Job Does Not Exist', null);
            return response()->json($res, 400);
        }
        if($validator->fails()){
            $res = ApiHelper::createApiResponse(true, 400, $validator->errors()->first(), null);
            return response()->json($res, 400);
        }else{
            try {
                $payload = $request->all();
                if(isset($payload['recruiter_id'])){
                    unset($payload['recruiter_id']);
                }
                $job->update($payload);
                $res = ApiHelper::createApiResponse(false, 200, 'Job updated successfully', null);
                return response()->json($res, 200);
            }catch (Exception $exception){
                return $this->throwDatabaseException($exception);
            }
        }

    }

    public function destroy($id){
        $job = Job::find($id);
        if($job){
            try {
                $job->delete();
                $res = ApiHelper::createApiResponse(false, 200, 'Job Deleted Successfully', null);
                return response()->json($res, 200);
            }catch (Exception $exception){
                return $this->throwDatabaseException($exception);
            }
        }else{
            $res = ApiHelper::createApiResponse(true, 400, 'Job Does Not Exist', null);
            return response()->json($res, 400);
        }

    }


    protected function filter($rows){
        if(request()->has('title') && request()->get('title') != ''){
            $rows = $rows->where('title', 'like', '%' . request()->get('title') . '%');
        }

        return $rows;
    }

    /**
     * @param $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function throwDatabaseException($exception): JsonResponse
    {
        $res = ApiHelper::createApiResponse(true, 400, $exception, null);
        return response()->json($res, 400);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    protected function storeValidation(Request $request)
    {
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

    /**
     * @param Request $request
     * @return mixed
     */
    protected function updateValidation(Request $request)
    {
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
