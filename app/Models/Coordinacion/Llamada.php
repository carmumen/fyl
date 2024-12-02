<?php

namespace App\Models\Coordinacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Llamada extends Model
{
    use HasFactory;

    protected $table = 'seguimiento_llamadas';
    
    protected $guarded = ['id'];

}