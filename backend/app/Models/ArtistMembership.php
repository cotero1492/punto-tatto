<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistMembership extends Model
{
    use HasFactory;

    protected $fillable = [
        'artist_id',
        'membership_id',
        'openpay_subscription_id',
        'status',
        'started_at',
        'expires_at',
        'cancelled_at',
        'auto_renew',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'expires_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'auto_renew' => 'boolean',
        ];
    }

    // Relaciones
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('expires_at', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now())
            ->orWhere('status', 'expired');
    }

    // Helpers
    public function isActive(): bool
    {
        return $this->status === 'active' && $this->expires_at > now();
    }

    public function isExpired(): bool
    {
        return $this->expires_at <= now() || $this->status === 'expired';
    }
}

