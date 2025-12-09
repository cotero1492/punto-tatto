<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artist extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'studio_name',
        'bio',
        'styles',
        'location',
        'latitude',
        'longitude',
        'address',
        'city',
        'state',
        'zip_code',
        'working_hours',
        'price_per_hour',
        'min_price',
        'portfolio_url',
        'social_media',
        'is_verified',
        'is_suspended',
        'views_count',
        'contacts_count',
        'rating_average',
        'reviews_count',
        'ranking_score',
        'ranking_position',
        'openpay_customer_id',
    ];

    protected function casts(): array
    {
        return [
            'styles' => 'array',
            'working_hours' => 'array',
            'social_media' => 'array',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'price_per_hour' => 'decimal:2',
            'min_price' => 'decimal:2',
            'rating_average' => 'decimal:2',
            'is_verified' => 'boolean',
            'is_suspended' => 'boolean',
            'views_count' => 'integer',
            'contacts_count' => 'integer',
            'reviews_count' => 'integer',
            'ranking_score' => 'integer',
            'ranking_position' => 'integer',
        ];
    }

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function membership()
    {
        return $this->hasOne(ArtistMembership::class)->where('status', 'active')->latest();
    }

    public function memberships()
    {
        return $this->hasMany(ArtistMembership::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function allReviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function advertisements()
    {
        return $this->hasMany(Advertisement::class);
    }

    // Scopes
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_suspended', false);
    }

    public function scopeFeatured($query)
    {
        return $query->whereHas('membership', function ($q) {
            $q->where('status', 'active');
        })->whereHas('membership.membership', function ($q) {
            $q->where('featured', true);
        });
    }

    public function scopeByStyle($query, $style)
    {
        return $query->whereJsonContains('styles', $style);
    }

    public function scopeByLocation($query, $city = null, $state = null)
    {
        if ($city) {
            $query->where('city', 'like', "%{$city}%");
        }
        if ($state) {
            $query->where('state', 'like', "%{$state}%");
        }
        return $query;
    }

    public function scopeOrderByRanking($query)
    {
        return $query->orderBy('ranking_score', 'desc')
            ->orderBy('rating_average', 'desc')
            ->orderBy('reviews_count', 'desc');
    }
}

