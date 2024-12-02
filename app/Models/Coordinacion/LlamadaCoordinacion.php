<?php

namespace App\Models\Coordinacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LlamadaCoordinacion extends Model
{
    use HasFactory;

    protected $table = 'seguimiento_llamada_coordinacion';
    
    protected $guarded = ['id'];

}