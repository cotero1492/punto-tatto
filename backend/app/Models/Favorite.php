<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'artist_id',
    ];

    // Relaciones
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}

