<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Point extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'points',
        'tipe',
        'sumber',
        'keterangan',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Get the user that owns these points.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
