<?php

namespace App\Http\Requests\Global;

use Illuminate\Foundation\Http\FormRequest;

class SaveCityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'canton_id' => ['required'],
            'code' => ['required'],
            'name' => ['required','min:4'],
            'type_division' => ['nullable'],
            'code_RDEP' => ['nullable'],
            'status' => ['required'],
        ];
    }
}
