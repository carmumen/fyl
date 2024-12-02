<?php

namespace App\Http\Requests\Global;

use Illuminate\Foundation\Http\FormRequest;

class SaveCatalogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'catalog_types_id' => ['required'],
            'name' => ['required','min:4'],
            'acronym' => ['required'],
            'status' => ['required'],
        ];
    }
}
