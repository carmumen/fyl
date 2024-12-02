<?php

namespace App\Http\Requests\Fyl;

use Illuminate\Foundation\Http\FormRequest;

class SaveFocusParticipantsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'training_id' => ['required'],
            'participant_DNI' => ['required'],
            'staff_DNI' => ['nullable'],
            'legendary_DNI' => ['nullable'],
            'attendance_status' => ['nullable'],
            'statement' => ['nullable'],
            'legendary_DNI' => ['nullable'],
            'follow_up' => ['nullable'],
            'logistics' => ['nullable'],
        ];
    }
}
