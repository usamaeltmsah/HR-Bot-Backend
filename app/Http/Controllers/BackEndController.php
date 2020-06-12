<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use App\Job;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class BackEndController extends Controller{
    protected $model;

    public function __construct(Model $model){
        $this->model = $model;
    }

    public function index(){
        try{
            $rows = $this->model;
            $rows = $this->filter($rows);
            $with = $this->with();
            if(!empty($with)){
                $rows = $rows->with($with);
            }
            $rows = $rows->orderBy('id', 'desc')->paginate();
            if($rows->total() > 0){
                $res = ApiHelper::createApiResponse(false, 200, '', $rows->items());
                $res['total'] = $rows->total();
                $res['perPage'] = $rows->perPage();
                $res['currentPage'] = $rows->currentPage();
                return response()->json($res, 200);
            }else{
                $errorMessage = 'There Are No ' . $this->getPluralModelName();
                $this->responseForBadRequest($errorMessage);
            }

        }catch (Exception $exception){
            return $this->throwDatabaseException($exception);
        }
    }

    public function show($id){
        $row = $this->model->find($id);
        if($row){
            $res = ApiHelper::createApiResponse(false, 200, '', $row);
            return response()->json($res, 200);
        }else{
            $errorMessage = $this->getModelName() . ' Does Not Exist';
            return $this->responseForBadRequest($errorMessage);
        }

    }

    public function store(Request $request){

        $validator = $this->storeValidator($request);

        if($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            $this->responseForBadRequest($errorMessage);
        }else{
            try{
                $this->model->create($request->all());
                $res = ApiHelper::createApiResponse(false, 201, $this->getModelName() . ' Added Successfully', null);
                return response()->json($res, 201);
            }catch (Exception $exception){
                return $this->throwDatabaseException($exception);
            }

        }
    }

    public function update($id, Request $request){

        $row = $this->model->find($id);
        $validator = $this->updateValidator($request);
        if($row == null){
            return $this->responseForBadRequest();
        }
        if($validator->fails()){
            $errorMessage = $validator->errors()->first();
            $this->responseForBadRequest($errorMessage);
        }else{
            try {
                $payload = $request->all();
                if(isset($payload['recruiter_id'])){
                    unset($payload['recruiter_id']);
                }
                $row->update($payload);
                $res = ApiHelper::createApiResponse(false, 200, $this->getModelName() . ' updated successfully', null);
                return response()->json($res, 200);
            }catch (Exception $exception){
                return $this->throwDatabaseException($exception);
            }
        }

    }

    public function destroy($id){
        $row = $this->model->find($id);
        if($row){
            try {
                $row->delete();
                $res = ApiHelper::createApiResponse(false, 200, $this->getModelName() . ' Deleted Successfully', null);
                return response()->json($res, 200);
            }catch (Exception $exception){
                return $this->throwDatabaseException($exception);
            }
        }else{
            $errorMessage = $this->getModelName() . ' Does Not Exist';
            return $this->responseForBadRequest($errorMessage);
        }

    }

    /****** helper methods  ******/

    /** validate the request to update a resource */
    protected function updateValidator(Request $request){
        $validator = Validator::make(['key' => 'value'], [
            'key' => ['required', 'string']
        ]);
        return $validator;
    }

    /** validate the request to store a resource */
    protected function storeValidator(Request $request){
        $validator = Validator::make(['key' => 'value'], [
            'key' => ['required', 'string']
        ]);
        return $validator;
    }

    /** filter data in index method by attaching parameters */
    protected function filter($rows){
        return $rows;
    }

    /** if you want to get some methods with data to improve the performance of the queries */
    protected function with(){
        return [];
    }

    /** set reply to the exception of the database in json format */
    protected function throwDatabaseException($exception){
        $res = ApiHelper::createApiResponse(true, 400, $exception, null);
        return response()->json($res, 400);
    }

    /** set reply to the Bad requests in json format */
    protected function responseForBadRequest($errorMessage){
        $res = ApiHelper::createApiResponse(true, 400, $errorMessage, null);
        return response()->json($res, 400);
    }

    /** get model name in plural format */
    protected function getPluralModelName(){
        return  Str::plural($this->getModelName());
    }

    /** get model name */
    protected function getModelName(){
        return class_basename($this->model);
    }

}
