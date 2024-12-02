<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Fyl\Campus;

class Users extends Model
{
    use HasFactory;

    protected $table = 'users';
    
    public function campuses()
    {
        return $this->belongsToMany(Campus::class, 'fyl_campus_user', 'user_id', 'campus_id');
    }
   
}