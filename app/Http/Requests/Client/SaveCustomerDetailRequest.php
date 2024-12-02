<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveCustomerDetailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'client_id' => ['required',
                                Rule::unique('client_customer_details')
                                     ->where(function ($query) {
                                return $query
                                    ->whereemployee_id($this->client_id)
                                    ->whereNotIn('id', [$this->id]);
                                }) 
                            ],
            
        ];
    }
}