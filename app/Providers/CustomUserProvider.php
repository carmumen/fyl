<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Contracts\Auth\UserProvider as UserProviderContract;
use Illuminate\Support\Facades\Hash;
use App\Models\UserLife; // Asegúrate de importar el modelo de UserLife aquí

class CustomUserProvider implements UserProviderContract
{
    protected $model;

    public function __construct(UserLife $model)
    {
        $this->model = $model;
    }

    // Métodos de la interfaz UserProviderContract

    public function retrieveById($identifier)
    {
        return $this->model->find($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {
        return $this->model->where('id', $identifier)->where('remember_token', $token)->first();
    }

    public function retrieveByCredentials(array $credentials)
    {
        // Implementa la lógica para buscar un usuario utilizando las credenciales proporcionadas
        // Por ejemplo, puedes buscar un usuario por su correo electrónico
        return $this->model->where('email', $credentials['email'])->first();
    }

    // Método para validar las credenciales del usuario
    public function validateCredentials(UserContract $user, array $credentials)
    {
        // Implementa la lógica para validar las credenciales del usuario
        // Por ejemplo, puedes comparar la contraseña proporcionada con la contraseña almacenada del usuario
        return Hash::check($credentials['password'], $user->getAuthPassword());
    }

    // Otros métodos de la interfaz UserProviderContract

    public function updateRememberToken(UserContract $user, $token)
    {
        // Implementa la lógica para actualizar el token de recordar usuario
        // Por ejemplo, puedes actualizar el campo 'remember_token' del usuario con el nuevo token
        $user->setRememberToken($token);
        $user->save();
    }

    // Puedes implementar más métodos de la interfaz UserProviderContract según tus necesidades
}
