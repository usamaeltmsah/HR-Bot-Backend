<?php

namespace App\Policies;

use App\User;
use App\Question;
use App\Interview;
use Illuminate\Auth\Access\HandlesAuthorization;

class InterviewPolicy
{
    use HandlesAuthorization;

    /**
     * Check wether the current user can access the given interview
     * @param  App\User   $user 
     * @param  App\Interview    $interview  
     * @return boolean
     */
    public function access(User $user, Interview $interview): bool
    {
        if($user->isRecruiter()) {
            return $interview->job->isCreatedBy($user);
        }

        if($user->isApplicant() && $interview->isTheApplicant($user)) {
            return $interview->isInProgress();
        }

        return False;
    }

    /**
     * Check wether the current user can answer the given question in the given interview
     * @param  App\User      $user
     * @param  App\Interview $interview
     * @param  App\Question  $question  
     * @return boolean
     */
    public function answer(User $user, Interview $interview, Question $question): bool
    {
        if($interview->hasQuestion($question)) {
            return ! $question->isAnsweredIn($interview);
        }

        return False;
    }

    /**
     * Check wether the current user can check the interview results
     * @param  App\User      $user
     * @param  App\Interview $interview
     * @return boolean
     */
    public function check_results(User $user, Interview $interview): bool
    {
        return $user->isApplicant() && $interview->isTheApplicant($user);
    }
}
