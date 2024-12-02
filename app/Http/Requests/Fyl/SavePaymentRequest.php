<?php

namespace App\Http\Requests\Fyl;

use Illuminate\Foundation\Http\FormRequest;

class SavePaymentRequest extends FormRequest
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
            'payment_date' => ['required'],
            'catalog_id_payment_method' => ['required'],
            'prices_id' => ['required'],
            'catalog_id_card' => ['nullable'],
            'catalog_id_tipo_pago' => ['nullable'],
            'catalog_id_bank' => ['nullable'],
            'authorization_number' => ['nullable'],
            'catalog_id_payment_record' => ['required'],
            'amount' => ['required','integer'],

            'DNI' => ['nullable'],
            'names' => ['nullable'],
            'email' => ['nullable'],
            'address' => ['nullable'],
            'phone' => ['nullable'],
        ];
    }
}
