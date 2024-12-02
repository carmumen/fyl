<?php

namespace App\Http\Requests\Security;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class SaveUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $email = $this->input('email');
        $this->merge([
            'password' => Hash::make($email),// $this->input('email');
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => [
                'required',
                    Rule::unique('users')
                        ->where(function ($query) {
                        return $query
                            ->whereemail($this->email)
                            ->whereNotIn('id', [$this->id]);
                        })
                    ],
            'status' => ['nullable'],
            'password' => ['nullable'],
            ];
    }
}
