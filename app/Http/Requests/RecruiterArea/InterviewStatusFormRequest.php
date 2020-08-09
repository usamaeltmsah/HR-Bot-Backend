<?php

namespace App\Http\Requests\RecruiterArea;

use Illuminate\Foundation\Http\FormRequest;

class InterviewStatusFormRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => [
                'required',
                'string',
                'in:under consideration,selected,not selected'
            ]
        ];
    }
}
