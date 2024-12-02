<?php

namespace App\Models\Fyl;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Transferencia extends Model
{
    use HasFactory;

    protected $table = 'fyl_transferencias';
    
    protected $guarded = ['id'];
}

