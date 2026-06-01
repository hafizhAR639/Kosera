<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    /**
     * Scope: Filter by user ID
     */
    public function scopeByUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Filter by status
     */
    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Scope: Filter pending orders
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->byStatus('pending');
    }

    /**
     * Scope: Filter completed orders
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->byStatus('completed');
    }

    /**
     * Scope: Eager load service and user data
     */
    public function scopeWithDetails(Builder $query): Builder
    {
        return $query->with([
            'service:id,user_id,nama_layanan,kategori,harga_mulai',
            'service.user:id,nama',
        ]);
    }

    /**
     * Check if order has been rated
     */
    public function isRated(): bool
    {
        return $this->rating !== null;
    }
}
