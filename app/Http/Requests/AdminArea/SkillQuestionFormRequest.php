<?php

namespace App\Http\Requests\AdminArea;

use Illuminate\Foundation\Http\FormRequest;

class SkillQuestionFormRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => ['required', 'string']
        ];
    }
}
