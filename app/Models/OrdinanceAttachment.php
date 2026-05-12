<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class OrdinanceAttachment extends Model
{
    protected $fillable = [
        'ordinance_id',
        'original_name',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
    ];

    public function ordinance(): BelongsTo
    {
        return $this->belongsTo(Ordinance::class);
    }
}
