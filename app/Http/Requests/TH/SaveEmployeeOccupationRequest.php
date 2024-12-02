<?php

namespace App\Http\Requests\TH;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveEmployeeOccupationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        session(['tab' => 2]);
        return [
            'employee_id' => ['required',
                                Rule::unique('th_employee_details')
                                     ->where(function ($query) {
                                return $query
                                    ->whereemployee_id($this->employee_id)
                                    ->whereNotIn('id', [$this->id]);
                                })
                            ],
            'evaluator' => ['required','max:2'],
            'job_title_id' => ['required'],
            'department_id' => ['required'],
            'entry_date' => ['required'],
            'departure_date' => ['nullable']
        ];
    }
}
