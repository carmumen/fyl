<?php

namespace App\Models\Fyl;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Campus extends Model
{
    use HasFactory;

    protected $table = 'fyl_campus';
    
    public function users()
    {
        return $this->belongsToMany(Users::class, 'fyl_campus_user', 'campus_id', 'user_id');
    }

}

