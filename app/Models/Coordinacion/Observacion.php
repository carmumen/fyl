<?php

namespace App\Models\Coordinacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    use HasFactory;

    protected $table = 'fyl_promesa_observacion';
    
    protected $fillable = [
        // Otras propiedades fillable...
        'promesa_id',
        'observacion',
        'user_id',
    ];

}