<?php

namespace App\Policies;

use App\User;
use App\Interview;
use Illuminate\Auth\Access\HandlesAuthorization;

class InterviewPolicy
{
    use HandlesAuthorization;

    /**
     * Check wether the current user can retrive the questions for the given job
     * @param  App\User   $user 
     * @param  App\Interview    $interview  
     * @return boolean
     */
    public function retrive_questions(User $user, Interview $interview): bool
    {

        if($user->isApplicant() && $interview->applicant_id == $user->getKey()) {
            return $interview->isInProgress();
        }

        return False;
    }
}
