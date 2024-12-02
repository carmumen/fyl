<?php

namespace App\Models;

use App\Models\Aplication;
use App\Models\Profile;
use App\Models\Functionality;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileFunctionality extends Model
{
    use HasFactory;

    protected $table = 'security_profile_functionalities';

    public function aplication()
    {
        return $this->belongsTo(Aplication::class);
    }
    public function functionality()
    {
        return $this->hasMany(Functionality::class);
    }
    public function profile()
    {
        return $this->hasMany(Profile::class);
    }
}