<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class AlternativeUser extends Authenticatable implements AuthenticatableContract
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fyl_login_life';
}

