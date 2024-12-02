<?php

namespace App\Models;

use App\Models\Aplication;
use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Functionality extends Model
{
    use HasFactory;

    protected $table = 'security_functionalities';

    public function aplication()
    {
        return $this->belongsTo(Aplication::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
