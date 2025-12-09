<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'duration_days',
        'max_photos',
        'featured',
        'priority_ranking',
        'ranking_bonus',
        'advanced_stats',
        'support_priority',
        'features',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'duration_days' => 'integer',
            'max_photos' => 'integer',
            'featured' => 'boolean',
            'priority_ranking' => 'boolean',
            'ranking_bonus' => 'integer',
            'advanced_stats' => 'boolean',
            'support_priority' => 'boolean',
            'features' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    // Relaciones
    public function artistMemberships()
    {
        return $this->hasMany(ArtistMembership::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}

