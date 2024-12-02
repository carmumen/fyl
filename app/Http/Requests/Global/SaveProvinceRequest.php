<?php

namespace App\Http\Requests\Global;

use Illuminate\Foundation\Http\FormRequest;

class SaveProvinceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'country_id' => ['required'],
            'code' => ['required'],
            'name' => ['required','min:4'],
            'code_RDEP' => ['nullable'],
            'code_MAP' => ['nullable'],
            'acronym' => ['required'],
            'status' => ['required'],
        ];
    }
}
