<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'DNI' => ['digits:10','required',
                                Rule::unique('th_employees')
                                     ->where(function ($query) {
                                return $query
                                    ->whereid($this->DNI)
                                    ->whereNotIn('id', [$this->id]);
                                }) ],
            'names' => ['required','min:4'],
            'surnames' => ['required','min:4'],
            'birthdate' => ['required'],
            'gender_catalog_id' => ['required'],
            'civil_status_catalog_id' => ['required'],
            'education_level_catalog_id' => ['required'],
            'address' => ['required'],
            'phone' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'status' => ['required']
        ];
    }
}
