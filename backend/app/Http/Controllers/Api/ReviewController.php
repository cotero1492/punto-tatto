<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $client = $request->user()->client;

        $request->validate([
            'artist_id' => 'required|exists:artists,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'photos' => 'nullable|array',
            'photos.*' => 'string',
        ]);

        // Verificar que no haya reseñado antes
        $existingReview = Review::where('artist_id', $request->artist_id)
            ->where('client_id', $client->id)
            ->first();

        if ($existingReview) {
            return response()->json([
                'message' => 'Ya has dejado una reseña para este artista',
            ], 422);
        }

        $review = Review::create([
            'artist_id' => $request->artist_id,
            'client_id' => $client->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'photos' => $request->photos,
            'is_approved' => false, // Requiere aprobación del admin
        ]);

        return response()->json([
            'review' => $review->load(['artist.user', 'client.user']),
            'message' => 'Reseña enviada exitosamente. Está pendiente de aprobación.',
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $client = $request->user()->client;
        $review = Review::where('client_id', $client->id)->findOrFail($id);

        $request->validate([
            'rating' => 'sometimes|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'photos' => 'nullable|array',
        ]);

        $review->update($request->only(['rating', 'comment', 'photos']));
        $review->update(['is_approved' => false]); // Requiere nueva aprobación

        return response()->json([
            'review' => $review->load(['artist.user', 'client.user']),
            'message' => 'Reseña actualizada exitosamente',
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $client = $request->user()->client;
        $review = Review::where('client_id', $client->id)->findOrFail($id);
        $review->delete();

        return response()->json([
            'message' => 'Reseña eliminada exitosamente',
        ]);
    }
}

