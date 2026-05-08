<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Official extends Model
{
    use HasFactory;

    protected $fillable = [
        'position_key',
        'name',
        'position',
        'department',
        'dob',
        'pob',
        'civil_status',
        'citizenship',
        'description',
        'photo_path',
    ];
}
