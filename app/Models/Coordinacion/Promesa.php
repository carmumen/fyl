<?php

namespace App\Models\Coordinacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promesa extends Model
{
    use HasFactory;

    protected $table = 'seguimiento_promesas';
    
    protected $guarded = ['id'];

}