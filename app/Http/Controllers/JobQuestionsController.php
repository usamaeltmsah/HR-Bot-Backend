<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;

class JobQuestionsController extends Controller
{
    // retrieve question for a specific job
    public function getQuestions(Job $job){
        return $job->questions;
    }
}
