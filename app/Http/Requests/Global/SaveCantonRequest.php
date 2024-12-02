<?php

namespace App\Http\Requests\Global;

use Illuminate\Foundation\Http\FormRequest;

class SaveCantonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'province_id' => ['required'],
            'code' => ['required'],
            'name' => ['required'],
            'status' => ['required'],
        ];
    }
}

