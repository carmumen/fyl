<?php

namespace App\Http\Requests\Fyl;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveParticipantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'DNI' => [
                'required',
                'regex:/^[0-9]{8,13}$/',
                function ($attribute, $value, $fail) {
                    if (!$this->validateCedulaEcuador($value)) {
                        $fail('La cédula no es válida.');
                    }
                },
                Rule::unique('th_employees')->where(function ($query) {
                    return $query
                        ->where('id', $this->input('DNI'))
                        ->whereNotIn('id', [$this->id]);
                }),
            ],
            'names' => ['required', 'min:4'],
            'surnames' => ['required', 'min:4'],
            'nickname' => ['required'],
            'birthdate' => ['nullable'],
            'gender_catalog_id' => ['nullable'],
            'civil_status_catalog_id' => ['nullable'],
            'city_of_residence' => ['nullable'],
            'address' => ['nullable'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'regex:/^[0-9]{8,13}$/'],
            'occupation' => ['nullable'],
            'emergency_contact' => ['nullable'],
            'emergency_contact_phone' => ['nullable', 'regex:/^[0-9]{8,13}$/'],
            'training_id_enroller' => ['nullable'],
            'DNI_enroller' => ['nullable'],
            'psychiatric_history' => ['nullable'],
            'psychiatric_history_details' => ['nullable'],
            'medical_history' => ['nullable'],
            'medical_history_details' => ['nullable'],
            'usual_medication' => ['nullable'],
            'usual_medication_details' => ['nullable'],
            'status' => ['nullable'],
        ];

    }
    private function validateCedulaEcuador($cedula)
    {
        if (strlen($cedula) !== 10) {
            return false;
        }

        $coeficients = [2, 1, 2, 1, 2, 1, 2, 1, 2];
        $sum = 0;

        for ($i = 0; $i < 9; $i++) {
            $result = $cedula[$i] * $coeficients[$i];
            $sum += $result > 9 ? $result - 9 : $result;
        }

        $calculatedLastDigit = ($sum % 10 === 0) ? 0 : 10 - ($sum % 10);
        $lastDigit = intval(substr($cedula, -1));

        return $lastDigit === $calculatedLastDigit;
    }
}
