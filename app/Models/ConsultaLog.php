<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultaLog extends Model
{
    protected $table = 'consultas_log';
    protected $fillable = ['consulta'];
    public $timestamps = false;
}
