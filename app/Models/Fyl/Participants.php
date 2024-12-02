<?php

namespace App\Models\Fyl;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participants extends Model
{
    use HasFactory;

    protected $table = 'fyl_participants';
    
    protected $guarded = ['id'];

}
