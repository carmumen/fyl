<?php

namespace App\Models;

use App\Models\Aplication;
use App\Models\Functionality;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $table = 'security_modules';

    public function aplication()
    {
        return $this->belongsTo(Aplication::class);
    }
    
    public function functionality()
    {
        return $this->hasMany(Functionality::class);
    }
}

