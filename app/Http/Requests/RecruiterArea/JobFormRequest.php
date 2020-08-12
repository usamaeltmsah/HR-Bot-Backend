<?php

namespace App\Http\Requests\RecruiterArea;

use App\Skill;
use App\Question;
use App\Rules\AllExist;
use App\Rules\AllQuestionsHaveModelAnswers;
use Illuminate\Foundation\Http\FormRequest;

class JobFormRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $data = $this->all();

        // Cast skills ids to be integers
        if (isset($data['skills'])) {
            $data['skills'] = $this->castToArrayOfUniqueIntegers($data['skills']);
        } else {
            $data['skills'] = [];
        }

        // Cast questions ids to be integers
        if (isset($data['questions'])) {
            $data['questions'] = $this->castToArrayOfUniqueIntegers($data['questions']);
        } else {
            $data['questions'] = [];
        }

        $this->replace($data);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => [
                'required', 
                'string', 
                'min:5'
            ],

            'description' => [
                'required', 
                'string', 
                'min:5'
            ],

            'accept_interviews_from' => [
                'required', 
                'date_format:Y-m-d H:i:s', 
            ],

            'accept_interviews_until' => [
                'required', 
                'date_format:Y-m-d H:i:s', 
                'after:accept_interviews_from'
            ],

            'interview_duration' => [
                'required', 
                'integer', 
                'min:1'
            ],

            'skills' => [
                'bail',
                'required',
                'array',
                new AllExist(Skill::class),
            ],

            'questions' => [
                'bail',
                'required',
                'array',
                new AllExist(Question::class),
                new AllQuestionsHaveModelAnswers(),
            ],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if(! $this->areGivenQuestionsRelatedToGivenSkills()) {
                $validator->errors()->add('questions', 'You can only choose questions that are attached to the skills you already have chosen');
            }
        });
    }

    /**
     * Check wether the given questions are related to the given skills
     * @return boolean
     */
    protected function areGivenQuestionsRelatedToGivenSkills(): bool
    {
        $data = $this->all();
        $skills = collect($data['skills']);
        $questions_skills = Question::whereIn('id', $data['questions'])->pluck('skill_id');
        return $questions_skills->diff($skills)->isEmpty();
    }

    /**
     * Cast the given values to array of unique integers
     * @param  mixed $values
     * @return array
     */
    protected function castToArrayOfUniqueIntegers($values): array
    {
        if (!is_array($values)) {
            $values = [$values];
        }

        return array_unique(array_map('intval', $values));
    }
}
