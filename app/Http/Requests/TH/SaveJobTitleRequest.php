<?php

namespace App\Http\Requests\TH;

use Illuminate\Foundation\Http\FormRequest;

class SaveJobTitleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'name' => ['required','min:4'],
            'description' => ['required'],
            'minimum_salary' => ['required','numeric'],
            'maximum_salary' => ['required','numeric','gt:minimum_salary'],
            'status' => ['required'],
        ];
    }
}
