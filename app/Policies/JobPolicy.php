<?php

namespace App\Policies;

use App\Job;
use App\User;
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
        if($user->isApplicant() && is_null($job->getInterviewFor($user))) {
            return True;
        }

        return False;
    }
}
