<?php

namespace App\Http\Requests\Security;

use Illuminate\Foundation\Http\FormRequest;

class SaveFunctionalityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'aplication_id' => ['required'],
            'module_id' => ['required'],
            'icon' => ['required'],
            'name' => ['required','min:4'],
            'order' =>  'numeric|required|min:1|max:99',
            'route' => ['required'],
            'state' => ['required'],
        ];
    }
}
