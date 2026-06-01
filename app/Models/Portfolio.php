<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Portfolio extends Model
{
    protected $table = 'portfolio';

    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'kategori',
        'tanggal_project',
        'client_name',
        'lokasi',
        'nilai_project',
        'durasi_hari',
        'foto_cover',
        'rating',
        'status',
    ];

    protected $casts = [
        'tanggal_project' => 'date',
        'nilai_project' => 'decimal:2',
        'rating' => 'decimal:1',
    ];

    /**
     * Get the user that owns this portfolio.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all images for this portfolio.
     */
    public function images(): HasMany
    {
        return $this->hasMany(PortfolioImage::class);
    }
}
