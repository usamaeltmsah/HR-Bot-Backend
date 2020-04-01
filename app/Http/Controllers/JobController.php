<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function getQuestions(Job $job){
        return $job->questions;
    }
}
