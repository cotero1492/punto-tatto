<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'artist_id',
        'title',
        'description',
        'image_url',
        'link_url',
        'type',
        'position',
        'start_date',
        'end_date',
        'clicks_count',
        'impressions_count',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'clicks_count' => 'integer',
            'impressions_count' => 'integer',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    // Relaciones
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            });
    }

    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    // Helpers
    public function incrementClicks()
    {
        $this->increment('clicks_count');
    }

    public function incrementImpressions()
    {
        $this->increment('impressions_count');
    }
}

