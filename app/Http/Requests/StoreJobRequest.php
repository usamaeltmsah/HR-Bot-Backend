<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string'],
            'desc' => ['required', 'string'],
            'accept_interviews_from' => ['required', 'date_format:Y-m-d H:i:s'],
            'accept_interviews_until' => ['required', 'date_format:Y-m-d H:i:s'],
            'interviews_duration' => ['required', 'date_format:Y-m-d H:i:s'],
            'recruiter_id' => ['required', 'integer']
        ];
    }
}
