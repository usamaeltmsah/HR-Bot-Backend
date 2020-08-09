<?php

namespace App\Http\Requests\ApplicantArea;

use Illuminate\Foundation\Http\FormRequest;

class InterviewAnswerFormRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => ['required', 'string'],
        ];
    }
}
