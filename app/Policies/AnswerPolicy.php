<?php

namespace App\Policies;

use App\User;
use App\Answer;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnswerPolicy
{
    use HandlesAuthorization;

    /**
     * User can 
     * @param  \App\User   $user   
     * @param  \App\Answer $answer 
     * @return boolean
     */
    public function modify(user $user, Answer $answer): bool
    {
        return $user->isRecruiter() && $user->can('access', $answer->interview);
    }
}
