<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Favorite;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function dashboard(Request $request)
    {
        $client = $request->user()->client;

        $stats = [
            'favorites_count' => $client->favorites()->count(),
            'reviews_count' => $client->reviews()->count(),
            'messages_unread' => $request->user()->receivedMessages()->unread()->count(),
        ];

        return response()->json([
            'client' => $client->load('user'),
            'stats' => $stats,
        ]);
    }

    public function getProfile(Request $request)
    {
        $client = $request->user()->client;

        return response()->json([
            'client' => $client->load('user'),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $client = $request->user()->client;
        $user = $request->user();

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'birth_date' => 'nullable|date',
            'preferred_contact_method' => 'nullable|in:internal,whatsapp,email',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($request->has('name')) {
            $user->update(['name' => $request->name]);
        }

        if ($request->has('phone')) {
            $user->update(['phone' => $request->phone]);
        }

        $client->update($request->only([
            'birth_date', 'preferred_contact_method'
        ]));

        return response()->json([
            'client' => $client->load('user'),
            'message' => 'Perfil actualizado exitosamente',
        ]);
    }

    public function getFavorites(Request $request)
    {
        $client = $request->user()->client;
        $favorites = $client->favorites()->with(['artist.user', 'artist.membership.membership'])->get();

        return response()->json([
            'favorites' => $favorites,
        ]);
    }

    public function addFavorite(Request $request, $artistId)
    {
        $client = $request->user()->client;

        $favorite = Favorite::firstOrCreate([
            'client_id' => $client->id,
            'artist_id' => $artistId,
        ]);

        return response()->json([
            'favorite' => $favorite->load('artist.user'),
            'message' => 'Artista agregado a favoritos',
        ], 201);
    }

    public function removeFavorite(Request $request, $artistId)
    {
        $client = $request->user()->client;

        $favorite = Favorite::where('client_id', $client->id)
            ->where('artist_id', $artistId)
            ->first();

        if ($favorite) {
            $favorite->delete();
        }

        return response()->json([
            'message' => 'Artista eliminado de favoritos',
        ]);
    }
}

