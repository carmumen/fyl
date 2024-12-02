<?php

namespace App\Models\Coordinacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;

    protected $table = 'fyl_participants_contrato';
    
    protected $fillable = [
        // Otras propiedades fillable...
        'participant_DNI',
        'training_id',
        'contrato',
        'vision',
        'proposito',
        'user_id',
        'estado',
    ];

}