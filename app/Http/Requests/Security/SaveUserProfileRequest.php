<?php

namespace App\Http\Requests\Security;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveUserProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
       
        return [
            'profile_id' => ['required'],
            'user_id' => ['required'],
            'state' => [
                'required', 
            Rule::unique('security_user_profiles')
                ->where(function ($query) {
                   return $query
                       ->whereprofile_id($this->profile_id)
                       ->whereuser_id($this->user_id);
                    //    ->whereNotIn('id', [$this->id]),
                }) 
            ]
            ];
    }
}
