<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function getArtists(Request $request)
    {
        $query = Artist::with(['user', 'membership.membership'])
            ->verified()
            ->active();

        // Filtros
        if ($request->has('style')) {
            $query->byStyle($request->style);
        }

        if ($request->has('city')) {
            $query->byLocation($request->city, $request->state);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('studio_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Ordenamiento
        $sort = $request->get('sort', 'ranking');
        switch ($sort) {
            case 'rating':
                $query->orderBy('rating_average', 'desc');
                break;
            case 'reviews':
                $query->orderBy('reviews_count', 'desc');
                break;
            case 'name':
                $query->orderBy('studio_name', 'asc');
                break;
            default:
                $query->orderByRanking();
        }

        $artists = $query->paginate($request->get('per_page', 12));

        return response()->json($artists);
    }

    public function getArtistProfile($id)
    {
        $artist = Artist::with([
            'user',
            'membership.membership',
            'galleries' => function ($q) {
                $q->ordered()->limit(20);
            },
            'reviews' => function ($q) {
                $q->approved()->with('client.user')->latest()->limit(10);
            }
        ])
        ->verified()
        ->active()
        ->findOrFail($id);

        // Incrementar vistas
        $artist->increment('views_count');

        return response()->json([
            'artist' => $artist,
        ]);
    }

    public function getStyles()
    {
        $styles = [
            'Realista',
            'Tradicional',
            'Minimalista',
            'Acuarela',
            'Blackwork',
            'Geométrico',
            'Japonés',
            'Tribal',
            'Neotradicional',
            'Dotwork',
        ];

        return response()->json([
            'styles' => $styles,
        ]);
    }
}

