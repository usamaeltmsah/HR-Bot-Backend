<?php

namespace App\Rules;

use App\Question;
use Illuminate\Contracts\Validation\Rule;

class AllQuestionsHaveModelAnswers implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $questions)
    {
        $questionsHaveModelAnswers = Question::has('modelAnswers')->whereIn('id', $questions)->pluck('id');

        return count($questionsHaveModelAnswers) === count(array_unique($questions));

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Only questions that have model answers can be used';
    }
}
