<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;


class UserLife extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $table = 'fyl_participants_life_login_view';
    
    protected $fillable = ['names_surnames', 'email', 'password'];

   
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        // lista de los nombres de los campos que no pueden ser asignados masivamente
    ];

}
