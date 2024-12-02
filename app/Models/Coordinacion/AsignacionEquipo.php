<?php

namespace App\Models\Coordinacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionEquipo extends Model
{
    use HasFactory;

    protected $table = 'fyl_asignacion_por_equipo';
    
    protected $guarded = ['id'];

}