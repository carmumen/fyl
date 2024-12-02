<?php

namespace App\Models;

use App\Models\Profile;
use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'security_user_profiles';

    public function user()
    {
        return $this->hasMany(Users::class);
    }
    public function profile()
    {
        return $this->hasMany(Profile::class);
    }
}