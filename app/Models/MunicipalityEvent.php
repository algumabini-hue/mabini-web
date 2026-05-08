<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MunicipalityEvent extends Model
{
    protected $fillable = ['title', 'caption', 'date', 'images'];

    protected $casts = [
        'images' => 'array', // Crucial for storing/retrieving multiple paths
        'date' => 'date',
    ];
}
