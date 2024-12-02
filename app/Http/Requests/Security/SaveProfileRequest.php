<?php

namespace App\Http\Requests\Security;

use Illuminate\Foundation\Http\FormRequest;

class SaveProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'aplication_id' => ['required'],
            'name' => ['required','min:4'],
            'state' => ['required'],
        ];
    }
}
