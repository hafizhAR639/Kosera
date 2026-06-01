<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    protected $fillable = [
        'user_id',
        'nama_sertifikat',
        'penerbit',
        'tanggal_terbit',
        'tanggal_kadaluarsa',
        'nomor_sertifikat',
        'file_path',
        'kategori',
        'status_verifikasi',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'tanggal_kadaluarsa' => 'date',
    ];

    /**
     * Get the user that owns this certificate.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
