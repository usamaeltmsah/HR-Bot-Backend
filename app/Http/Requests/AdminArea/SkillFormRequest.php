<?php

namespace App\Http\Requests\AdminArea;

use Illuminate\Foundation\Http\FormRequest;

class SkillFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required', 
                'string',
                'min:1',
            ]
        ];
    }
}
