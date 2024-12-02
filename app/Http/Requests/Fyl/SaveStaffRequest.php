<?php

namespace App\Http\Requests\Fyl;

use Illuminate\Foundation\Http\FormRequest;

class SaveStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'training_id' => ['required'],
            'program_id' => ['required'],
            'role' => ['required'],
            'participant_DNI' => ['required'],
        ];
    }
}
