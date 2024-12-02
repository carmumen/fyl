<?php

namespace App\Models\Coordinacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignaciones extends Model
{
    use HasFactory;

    protected $table = 'fyl_asignaciones';
    
    protected $guarded = ['id'];

}