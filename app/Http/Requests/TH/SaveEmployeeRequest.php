<?php

namespace App\Http\Requests\TH;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        $validaTag1 = [
            'DNI' => [
                'required',
                'regex:/^[0-9]{8,13}$/',
                Rule::unique('th_employees')->where(function ($query) {
                    return $query
                        ->where('id', $this->input('DNI'))
                        ->whereNotIn('id', [$this->id]);
                }),
            ],
            'names' => ['required', 'min:4'],
            'surnames' => ['required', 'min:4'],
            'isUser' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'status' => ['required'],
        ];

        return $this->get('tagName') == "1" ? $validaTag1 : [];
    }
}

