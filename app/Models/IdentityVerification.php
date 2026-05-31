<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IdentityVerification extends Model
{
    protected $table = 'identity_verifications';

    protected $fillable = [
        'user_id',
        'nik',
        'foto_ktp',
        'selfie_ktp',
        'status',
    ];

    /**
     * Get the user that owns this identity verification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
