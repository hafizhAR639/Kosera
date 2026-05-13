<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'order_code',
        'user_id',
        'service_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'alamat_lengkap',
        'tanggal_order',
        'tanggal_mulai',
        'tanggal_selesai',
        'total_harga',
        'status',
        'payment_status',
        'catatan_customer',
        'catatan_mitra',
        'rating',
        'review',
    ];

    protected $casts = [
        'tanggal_order' => 'date',
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'total_harga' => 'decimal:2',
        'rating' => 'decimal:1',
    ];

    /**
     * Get the user (mitra) that owns this order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the service associated with this order.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the earning associated with this order.
     */
    public function earning(): HasOne
    {
        return $this->hasOne(Earning::class);
    }
}
