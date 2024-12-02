<?php

namespace App\Http\Requests\Security;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveProfileFunctionalitiesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
       
        return [
            'aplication_id' => ['required'],
            'profile_id' => ['required'],
            'functionality_id' => ['required'],
            'state' => [
                'required', 
            
            Rule::unique('security_profile_functionalities')
                ->where(function ($query) {
                   return $query
                       ->whereaplication_id($this->aplication_id)
                       ->whereprofile_id($this->profile_id)
                       ->wherefunctionality_id($this->functionality_id)
                       ->whereNotIn('id', [$this->id]);
                }) 
            ]
            ];
    }
}
