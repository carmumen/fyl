<?php

namespace App\Http\Requests\TH;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveSalaryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'employee_id' => ['required',
                                Rule::unique('th_employee_details')
                                     ->where(function ($query) {
                                return $query
                                    ->whereemployee_id($this->employee_id)
                                    ->whereNotIn('id', [$this->id]);
                                }) 
                            ],
            'amount' => ['required'],
        ];
    }
}
