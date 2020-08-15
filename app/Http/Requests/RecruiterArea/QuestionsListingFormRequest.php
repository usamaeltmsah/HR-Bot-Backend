<?php

namespace App\Http\Requests\RecruiterArea;

use App\Skill;
use App\Rules\AllExist;
use Illuminate\Foundation\Http\FormRequest;

class QuestionsListingFormRequest extends FormRequest
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
            'skills' => [
                'bail',
                'required',
                'array',
                new AllExist(Skill::class),
            ],
        ];
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
