<?php

namespace App\Models\Coordinacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservacionContrato extends Model
{
    use HasFactory;

    protected $table = 'fyl_contrato_observacion';
    
    protected $fillable = [
        // Otras propiedades fillable...
        'contrato_id',
        'observacion',
        'user_id',
    ];

}