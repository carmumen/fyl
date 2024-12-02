<?php

namespace App\Http\Requests\Fyl;

use Illuminate\Foundation\Http\FormRequest;

class SaveTrainingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'campus_id' => ['required'],
            'program_id' => ['required'],
            'sequential_number' => ['required'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'status' => ['required'],
        ];
    }
}
