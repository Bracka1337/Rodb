<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gameds extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'game_id',
    ];
}
