<?php

namespace App\Http\Requests\Security;

use Illuminate\Foundation\Http\FormRequest;

class SaveModuleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'aplication_id' => ['required'],
            'parent' => ['required'],
            'name' => ['required','min:4'],
            'order' =>  'numeric|required|min:1|max:99',
            'state' => ['required'],
        ];
    }
}
