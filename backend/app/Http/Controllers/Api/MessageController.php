<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Obtener conversaciones (último mensaje de cada conversación)
        $conversations = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get()
            ->groupBy(function ($message) use ($user) {
                return $message->sender_id === $user->id 
                    ? $message->receiver_id 
                    : $message->sender_id;
            })
            ->map(function ($messages) {
                return $messages->first();
            })
            ->values();

        return response()->json([
            'conversations' => $conversations,
        ]);
    }

    public function show(Request $request, $userId)
    {
        $currentUser = $request->user();
        
        // Verificar que el usuario existe
        $otherUser = User::findOrFail($userId);

        // Obtener mensajes entre los dos usuarios
        $messages = Message::betweenUsers($currentUser->id, $userId)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Marcar mensajes como leídos
        Message::betweenUsers($currentUser->id, $userId)
            ->where('receiver_id', $currentUser->id)
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json([
            'messages' => $messages,
            'other_user' => $otherUser,
        ]);
    }

    public function store(Request $request)
    {
        $sender = $request->user();

        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        // Verificar que no sea el mismo usuario
        if ($sender->id == $request->receiver_id) {
            return response()->json([
                'message' => 'No puedes enviarte mensajes a ti mismo',
            ], 422);
        }

        // Para clientes: solo pueden contactar artistas
        // Para artistas: pueden responder a cualquier usuario
        if ($sender->isClient()) {
            $receiver = User::findOrFail($request->receiver_id);
            if (!$receiver->isArtist()) {
                return response()->json([
                    'message' => 'Solo puedes contactar artistas',
                ], 403);
            }

            // Incrementar contador de contactos del artista
            $receiver->artist->increment('contacts_count');
        }

        $message = Message::create([
            'sender_id' => $sender->id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return response()->json([
            'message' => $message->load(['sender', 'receiver']),
        ], 201);
    }
}

