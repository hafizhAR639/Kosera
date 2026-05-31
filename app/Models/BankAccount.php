<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankAccount extends Model
{
    protected $table = 'bank_accounts';

    protected $fillable = [
        'user_id',
        'nama_bank',
        'nama_rekening',
        'nomor_rekening',
        'alamat_bank',
    ];

    /**
     * Get the user that owns this bank account.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
