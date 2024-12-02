<?php

namespace App\Http\Requests\Fyl;

use Illuminate\Foundation\Http\FormRequest;

class SaveProgramsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required','min:4'],
            'life_stage' => ['required'],
            'level' => ['required'],
            'status' => ['required'],
        ];
    }
}

