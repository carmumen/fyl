<?php

namespace App\Http\Requests\Fyl;

use Illuminate\Foundation\Http\FormRequest;

class SaveFdsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'campus_id' => ['required'],
            'training_in_game' => ['required'],
            'start_date' => ['required'],
            'end_date' => ['required'],
        ];
    }
}
