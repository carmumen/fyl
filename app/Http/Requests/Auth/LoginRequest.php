<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\AuthManager;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\UserLife; // Importa el modelo

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
     
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) 
        {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }
     
     /*
    public function authenticate(): void
    {
       //dd($request);
        
        $this->ensureIsNotRateLimited();
    
        $credentials = $this->only('email', 'password');

        // Intentar autenticar al usuario
        if (! Auth::attempt($credentials, $this->boolean('remember'))) {
            
            // Si el usuario no se encuentra en la tabla users, buscarlo en otra tabla
            $user = UserLife::where('email', $credentials['email'])->first();
            
            
            
            
            // Intentar autenticar al usuario con el guard 'userlife'
            if ($user && Auth::guard('life')->attempt($credentials, $this->boolean('remember'))) {
                // Obtener el usuario autenticado desde el guard 'userlife'
                $user = Auth::guard('life')->user();
                //dd($authenticatedUser);
                $authManager = app(AuthManager::class);
                $authManager->login($user, $this->boolean('remember'));
                
                // Asignar manualmente el usuario autenticado al objeto $request
                $this->setUserResolver(function () use ($user) {
                    return $user;
                });
            } else {
                RateLimiter::hit($this->throttleKey());
                throw ValidationException::withMessages([
                    'email' => trans('auth.failed'),
                ]);
            }
        }
    
        RateLimiter::clear($this->throttleKey());
    }
    */
     
    /* 
     
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) 
        {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }
    
    */

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')).'|'.$this->ip());
    }
}
