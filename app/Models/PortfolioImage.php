<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioImage extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'portfolio_id',
        'image_path',
        'caption',
        'urutan',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Get the portfolio that owns this image.
     */
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }
}
