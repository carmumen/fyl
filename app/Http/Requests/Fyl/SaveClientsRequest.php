<?php

namespace App\Http\Requests\Fyl;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveClientsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'CC_RUC' => [
                'required',
                'regex:/^[0-9]{8,13}$/',
                Rule::unique('fyl_clients', 'id')->where(function ($query) {
                    return $query->where('CC_RUC', $this->input('CC_RUC'))->whereNotIn('CC_RUC', [$this->id]);
                }),
            ],
            'names_razon_social' => ['required'],
            'address' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'CC_RUC.unique' => 'El número ya se encuentra registrado.',
            // ... tus otros mensajes personalizados aquí ...
        ];
    }
}
