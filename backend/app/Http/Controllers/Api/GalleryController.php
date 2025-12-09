<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $artist = $request->user()->artist;
        $galleries = $artist->galleries()->ordered()->get();

        return response()->json([
            'galleries' => $galleries,
        ]);
    }

    public function store(Request $request)
    {
        $artist = $request->user()->artist;

        // Verificar límite de fotos según membresía
        $membership = $artist->membership;
        if ($membership && $membership->membership->max_photos) {
            $currentCount = $artist->galleries()->count();
            if ($currentCount >= $membership->membership->max_photos) {
                return response()->json([
                    'message' => 'Has alcanzado el límite de fotos para tu plan de membresía',
                ], 403);
            }
        }

        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'required|string',
            'image_type' => 'nullable|in:image,video',
            'style' => 'nullable|string',
            'body_part' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
        ]);

        $gallery = $artist->galleries()->create($request->all());

        return response()->json([
            'gallery' => $gallery,
            'message' => 'Imagen agregada exitosamente',
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $artist = $request->user()->artist;
        $gallery = $artist->galleries()->findOrFail($id);

        return response()->json([
            'gallery' => $gallery,
        ]);
    }

    public function update(Request $request, $id)
    {
        $artist = $request->user()->artist;
        $gallery = $artist->galleries()->findOrFail($id);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'style' => 'nullable|string',
            'body_part' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $gallery->update($request->all());

        return response()->json([
            'gallery' => $gallery,
            'message' => 'Imagen actualizada exitosamente',
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $artist = $request->user()->artist;
        $gallery = $artist->galleries()->findOrFail($id);
        $gallery->delete();

        return response()->json([
            'message' => 'Imagen eliminada exitosamente',
        ]);
    }
}

