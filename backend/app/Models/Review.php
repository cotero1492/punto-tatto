<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'artist_id',
        'client_id',
        'rating',
        'comment',
        'photos',
        'is_approved',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'photos' => 'array',
            'is_approved' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    // Relaciones
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Events
    protected static function booted()
    {
        static::created(function ($review) {
            $review->updateArtistStats();
        });

        static::updated(function ($review) {
            $review->updateArtistStats();
        });

        static::deleted(function ($review) {
            $review->updateArtistStats();
        });
    }

    public function updateArtistStats()
    {
        $artist = $this->artist;
        $reviews = $artist->allReviews()->approved()->get();
        
        $artist->reviews_count = $reviews->count();
        $artist->rating_average = $reviews->avg('rating') ?? 0;
        $artist->save();
    }
}

