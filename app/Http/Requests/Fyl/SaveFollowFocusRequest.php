<?php

namespace App\Http\Requests\Fyl;

use Illuminate\Foundation\Http\FormRequest;

class SaveFollowFocusRequest extends FormRequest
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
            'date_call' => ['required'],
            'confirm_assistance_catalog_id' => ['required'],
            'phone_summary' => ['nullable'],
        ];
    }
}
