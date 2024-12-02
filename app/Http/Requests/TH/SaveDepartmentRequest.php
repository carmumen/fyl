<?php

namespace App\Http\Requests\TH;

use Illuminate\Foundation\Http\FormRequest;

class SaveDepartmentRequest extends FormRequest
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
            'status' => ['required'],
        ];
    }
}
