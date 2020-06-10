<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(){
        $rows = Job::get();
        return $rows;
    }

    public function show($id){
        dd('show');
    }

    public function store($id, Request $request){
        dd('store');
    }

    public function update($id, Request $request){
        dd('update');
    }

    public function destroy($id){
        dd('destroy');
    }
}
