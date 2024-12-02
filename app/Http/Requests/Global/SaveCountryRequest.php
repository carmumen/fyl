<?php

namespace App\Http\Requests\Global;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveCountryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'acronym' => ['required','max:4'],
            'area_code' => ['max:100'],
            'name' => ['required',
                        Rule::unique('global_countries')
                            ->where(function ($query) {
                            return $query
                                ->wherename($this->name)
                                ->whereNotIn('id', [$this->id]);
                            }) 
                        ],
            'tax_haven' => ['required'],
            'status' => ['required'],
        ];
    }
}