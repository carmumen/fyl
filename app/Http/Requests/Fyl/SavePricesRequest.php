<?php

namespace App\Http\Requests\Fyl;

use Illuminate\Foundation\Http\FormRequest;

class SavePricesRequest extends FormRequest
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
            'description' => ['required'],
            'programs_included' => ['required'],
            'catalogo_id_currency' => ['required'],
            'catalogo_id_price_type' => ['required'],
            'price' => ['required'],
            'id_contifico' => ['nullable'],
            'pvp_contifico' => ['nullable'],
            'status' => ['required'],
        ];
    }
}
