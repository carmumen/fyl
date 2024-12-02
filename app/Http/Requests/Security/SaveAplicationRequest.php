<?php

namespace App\Http\Requests\Security;

use Illuminate\Foundation\Http\FormRequest;

class SaveAplicationRequest extends FormRequest
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
            'icon' => ['required'],
            'start_path' => ['required'],
            'order' => ['required'],
            'state' => ['required'],
        ];
    }
}
