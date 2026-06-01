<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Earning extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'order_id',
        'jumlah',
        'tipe',
        'status',
        'tanggal_bayar',
        'metode_pembayaran',
        'catatan',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'tanggal_bayar' => 'date',
        'created_at' => 'datetime',
    ];

    /**
     * Get the user that owns this earning.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order associated with this earning.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
