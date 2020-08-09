<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Job extends Model
{

    protected $fillable = [
        'title',
        'description',
        'accept_interviews_from',
        'accept_interviews_until',
        'interview_duration',
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

    /**
     * Check wether the given user is the one created this job
     * @param  \App\User    $user
     * @return boolean       
     */
    public function isCreatedBy(User $user): bool
    {
        return $user->getKey() == $this->recruiter_id;
    }
    
    /**
     * Check whether this job is accepting interviews
     * @return boolean
     */
    public function isAcceptingInteviews(): bool
    {
        return now()->between($this->accept_interviews_from, $this->accept_interviews_until);
    }

    /**
     * Check wether this job has interview for the given user
     * 
     * @param  \App\User    $user
     * @return \App\Interview
     */
    public function getInterviewFor(User $user): ?Interview
    {
        return $this->interviews()->where('applicant_id', $user->getKey())->first();
    }

    /**
     * only jobs that are accepting interviews
     * 
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAcceptingInterviews(Builder $query): Builder
    {
        return $query->where('accept_interviews_from', '<', now())
                    ->where('accept_interviews_until', '>', now());
    }

    /**
     * only jobs that the given user didn't apply on it before
     * 
     * @param  \Illuminate\Database\Eloquent\Builder    $query
     * @param  \App\User                                $user
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDidntApplyBefore(Builder $query, User $user): Builder
    {
        return $query->whereDoesntHave('interviews', function (Builder $query) use ($user) {
            $query->whereIsTheApplicant($user);
        });
    }

    /**
     * only jobs that are created by the given user
     * 
     * @param  \Illuminate\Database\Eloquent\Builder    $query
     * @param  \App\User                                $user
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCreatedBy(Builder $query, User $user): Builder
    {
        return $query->where('recruiter_id', $user->getKey());
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
