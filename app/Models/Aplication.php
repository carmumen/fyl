<?php

namespace App\Models;

use App\Models\Module;
use App\Models\Functionality;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aplication extends Model
{
    use HasFactory;

    protected $table = 'security_aplications';

    public function module()
    {
        return $this->hasMany(Module::class);
    }
    public function functionality()
    {
        return $this->hasMany(Functionality::class);
    }

}
