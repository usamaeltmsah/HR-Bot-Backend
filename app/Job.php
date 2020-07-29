<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{

    protected $fillable = [
        'title',
        'desc',
        'accept_interviews_from',
        'accept_interviews_until',
        'interviews_duration',
        'recruiter_id'
    ];


    public function questions(){
        return $this->belongsToMany(Question::class, 'job_questions');
    }

    /**
     * A job may have one or more done interviews
     */
    public function interviews(){
        return $this->hasMany(Interview::class, 'job_id');
    }

    /*
     * must be run after creating the recruiters table
     */

//    public function recruiter(){
//        return $this->belongsTo(RecruiterModel::class, 'recruiter_id');
//    }

    /*
     * must be run after creating the job_skills table
     */

//    public function skills(){
//        return $this->belongsToMany(Skill::class, 'job_skills');
//    }

}
