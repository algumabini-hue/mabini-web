<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Ordinance extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_implemented',
        'subject',
        'attachments' // ADD THIS LINE
    ];

    // 2. Tell Laravel to automatically cast these JSON columns into PHP arrays
    protected $casts = [
        'signed_by' => 'array',
        'sections' => 'array',
        'attachments' => 'array', // ADD THIS LINE
        'date_implemented' => 'date' // Good practice for date formatting
    ];
}
