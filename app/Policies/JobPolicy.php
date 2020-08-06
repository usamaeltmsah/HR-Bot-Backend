<?php

namespace App\Policies;

use App\Job;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPolicy
{
    use HandlesAuthorization;

    /**
     * Check wether the current user can retrive the questions for the given job
     * @param  App\User   $user 
     * @param  App\Job    $job  
     * @return boolean
     */
    public function retriveQuestions(User $user, Job $job): bool
    {
        if($user->isRecruiter()) {
        	return $job->isCreatedBy($user);
        }

        if($user->isApplicant()) {
            if($interview = $job->getInterviewFor($user)) {
                return $interview->isInProgress();
            }
        }

        return False;
    }

    /**
     * Check wether the current user can apply on the given job
     * @param  App\User   $user 
     * @param  App\Job    $job  
     * @return boolean
     */
    public function apply(User $user, Job $job): bool
    {
        if($user->isRecruiter()) {
            return False;
        }

        if($user->isApplicant()) {
            if($interview = $job->getInterviewFor($user)) {
                return False;
            }
        }

        return True;
    }
}
