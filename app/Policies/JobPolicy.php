<?php

namespace App\Policies;

use App\Job;
use App\User;
use App\Interview;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPolicy
{
    use HandlesAuthorization;

    /**
     * Check wether the current user can apply on the given job
     * @param  App\User   $user 
     * @param  App\Job    $job  
     * @return boolean
     */
    public function apply(User $user, Job $job): bool
    {
        if($user->isApplicant() && $job->isAcceptingInteviews() &&  is_null($job->getInterviewFor($user))) {
            return True;
        }

        return False;
    }

    /**
     * Check wether the current user can modify the given job
     * 
     * @param  App\User   $user 
     * @param  App\Job    $job  
     * @return boolean
     */
    public function modify(User $user, Job $job): bool
    {
        return $user->isRecruiter() && $job->isCreatedBy($user);
    }

    /**
     * Check if the current user can access the job interview report
     *
     * @param  App\User         $user 
     * @param  App\Job          $job 
     * @param  App\Interview    $interview 
     * @return boolean
     */
    public function access_job_interview_report(User $user, Job $job, Interview $interview): bool
    {
        return $this->modify($user, $job) && $interview->isForJob($job);
    }
}
