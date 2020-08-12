<?php

namespace App\Policies;

use App\User;
use App\Question;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
{
    use HandlesAuthorization;

    /**
     * Check wether the current user can apply on the given job
     * @param  App\User   $user 
     * @param  App\Question    $job  
     * @return boolean
     */
    public function use(User $user, Question $question): bool
    {
        if($user->isRecruiter() && $question->modelAnswers->isNotEmpty()) {
            return True;
        }

        return False;
    }
}
