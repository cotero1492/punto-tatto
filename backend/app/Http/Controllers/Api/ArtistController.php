<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function dashboard(Request $request)
    {
        $artist = $request->user()->artist;
        
        if (!$artist) {
            return response()->json(['message' => 'Artista no encontrado'], 404);
        }

        $stats = [
            'total_views' => $artist->views_count,
            'total_contacts' => $artist->contacts_count,
            'rating' => $artist->rating_average,
            'reviews_count' => $artist->reviews_count,
            'ranking_position' => $artist->ranking_position,
            'gallery_count' => $artist->galleries()->count(),
            'messages_unread' => $artist->user->receivedMessages()->unread()->count(),
            'membership_status' => $artist->membership ? $artist->membership->status : null,
        ];

        return response()->json([
            'artist' => $artist->load(['user', 'membership.membership']),
            'stats' => $stats,
        ]);
    }

    public function getProfile(Request $request)
    {
        $artist = $request->user()->artist;
        
        return response()->json([
            'artist' => $artist->load(['user', 'membership.membership', 'galleries']),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $artist = $request->user()->artist;
        $user = $request->user();

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'studio_name' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'styles' => 'nullable|array',
            'location' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zip_code' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'working_hours' => 'nullable|array',
            'price_per_hour' => 'nullable|numeric|min:0',
            'min_price' => 'nullable|numeric|min:0',
            'portfolio_url' => 'nullable|url',
            'social_media' => 'nullable|array',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($request->has('name')) {
            $user->update(['name' => $request->name]);
        }

        if ($request->has('phone')) {
            $user->update(['phone' => $request->phone]);
        }

        $artist->update($request->only([
            'studio_name', 'bio', 'styles', 'location',
            'address', 'city', 'state', 'zip_code',
            'latitude', 'longitude', 'working_hours',
            'price_per_hour', 'min_price', 'portfolio_url',
            'social_media'
        ]));

        return response()->json([
            'artist' => $artist->load(['user', 'membership.membership']),
            'message' => 'Perfil actualizado exitosamente',
        ]);
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048',
        ]);

        $user = $request->user();
        
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $user->update(['photo' => $path]);
        }

        return response()->json([
            'photo' => $user->photo,
            'message' => 'Foto actualizada exitosamente',
        ]);
    }

    public function getMembership(Request $request)
    {
        $artist = $request->user()->artist;
        $membership = $artist->membership;

        return response()->json([
            'membership' => $membership ? $membership->load('membership') : null,
            'memberships' => \App\Models\Membership::active()->ordered()->get(),
        ]);
    }

    public function statistics(Request $request)
    {
        $artist = $request->user()->artist;

        $stats = [
            'views' => [
                'total' => $artist->views_count,
                'this_month' => 0, // Implementar lógica de estadísticas por mes
            ],
            'contacts' => [
                'total' => $artist->contacts_count,
                'this_month' => 0,
            ],
            'gallery' => [
                'total_photos' => $artist->galleries()->count(),
                'total_views' => $artist->galleries()->sum('views_count'),
                'total_likes' => $artist->galleries()->sum('likes_count'),
            ],
            'reviews' => [
                'average' => $artist->rating_average,
                'total' => $artist->reviews_count,
                'by_rating' => [
                    '5' => $artist->reviews()->where('rating', 5)->count(),
                    '4' => $artist->reviews()->where('rating', 4)->count(),
                    '3' => $artist->reviews()->where('rating', 3)->count(),
                    '2' => $artist->reviews()->where('rating', 2)->count(),
                    '1' => $artist->reviews()->where('rating', 1)->count(),
                ],
            ],
        ];

        return response()->json($stats);
    }
}

