<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'user_id',
        'nama_layanan',
        'kategori',
        'deskripsi',
        'harga_mulai',
        'harga_max',
        'satuan',
        'durasi_estimasi',
        'area_layanan',
        'foto',
        'status',
        'views',
    ];

    protected $casts = [
        'harga_mulai' => 'decimal:2',
        'harga_max' => 'decimal:2',
    ];

    /**
     * Get the user that owns this service.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all orders for this service.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Compatibility accessor for image URL used in views.
     * Returns primary foto, fallback to foto_cover, else null.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->foto ?? $this->foto_cover ?? null;
    }
}
