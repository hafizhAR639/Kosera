<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'phone',
        'location',
        'bio',
        'avatar',
        'join_date',
        'status',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'join_date' => 'datetime',
        ];
    }

    /**
     * Get all certificates for the user.
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    /**
     * Get all portfolios for the user.
     */
    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class);
    }

    /**
     * Get all services for the user.
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Get all orders for the user.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get all earnings for the user.
     */
    public function earnings(): HasMany
    {
        return $this->hasMany(Earning::class);
    }

    /**
     * Get all points for the user.
     */
    public function points(): HasMany
    {
        return $this->hasMany(Point::class);
    }

    /**
     * Get all bank accounts for the user.
     */
    public function bankAccounts(): HasMany
    {
        return $this->hasMany(BankAccount::class);
    }

    /**
     * Get all identity verifications for the user.
     */
    public function identityVerifications(): HasMany
    {
        return $this->hasMany(IdentityVerification::class);
    }

    /**
     * Compatibility accessor for avatar used in views.
     * Returns avatar URL or a placeholder if empty.
     */
    public function getAvatarAttribute(?string $value): ?string
    {
        if (!empty($value)) {
            return $value;
        }

        return 'https://via.placeholder.com/150?text=Avatar';
    }
}
