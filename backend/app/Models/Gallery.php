<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'artist_id',
        'title',
        'description',
        'image_url',
        'image_type',
        'style',
        'body_part',
        'views_count',
        'likes_count',
        'is_featured',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'views_count' => 'integer',
            'likes_count' => 'integer',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    // Relaciones
    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    // Scopes
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
    }

    public function scopeByStyle($query, $style)
    {
        return $query->where('style', $style);
    }
}

