<?php

namespace App\Http\Requests\RecruiterArea;

use Illuminate\Foundation\Http\FormRequest;

class AnswerScoreFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'score' => [
                'required',
                'numeric',
                'min:0',
            ]
        ];
    }
}
