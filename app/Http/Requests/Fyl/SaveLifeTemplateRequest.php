<?php

namespace App\Http\Requests\Fyl;

use Illuminate\Foundation\Http\FormRequest;

class SaveLifeTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'activity' => ['required'],
            'order' => ['required','integer'],
            'status' => ['required'],
        ];
    }
}

