<?php

namespace App\Http\Requests\Fyl;

use Illuminate\Foundation\Http\FormRequest;

class SaveLifeCalendarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'training_id' => ['required'],
            //'activity' => ['required'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'start_hour' => ['required'],
            'end_hour' => ['required'],
        ];
    }
}
