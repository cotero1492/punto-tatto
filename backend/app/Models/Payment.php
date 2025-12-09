<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'artist_id',
        'artist_membership_id',
        'membership_id',
        'openpay_transaction_id',
        'openpay_subscription_id',
        'amount',
        'status',
        'type',
        'payment_method',
        'metadata',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'metadata' => 'array',
            'paid_at' => 'datetime',
        ];
    }

    // Relaciones
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function artistMembership()
    {
        return $this->belongsTo(ArtistMembership::class);
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }
}

