<?php

namespace App\Http\Requests\Global;

use Illuminate\Foundation\Http\FormRequest;

class SaveCatalogTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'name' => ['required','min:4'],
            'status' => ['required'],
        ];
    }
}
