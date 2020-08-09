<?php

namespace App\Http\Requests\RecruiterArea;

use Illuminate\Foundation\Http\FormRequest;

class JobFormRequest extends FormRequest
{
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
                'after:now'
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
        ];
    }
}
