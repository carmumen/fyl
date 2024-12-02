<?php

namespace App\Models;

use App\Models\Aplication;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'security_profiles';

    public function aplication()
    {
        return $this->belongsTo(Aplication::class);
    }
}