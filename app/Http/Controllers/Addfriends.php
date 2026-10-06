<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Addfriend;
use App\Models\User;

class Addfriends extends Controller
{
    public function addfriend(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'id_number' => 'required',
        ]);

        $userId = (int) $request->user_id;

        // Find the user by number_id
        $friend = User::where(
            'number_id',
            $request->id_number
        )->first();

        if (!$friend) {
            return response()->json([
                'success' => false,
                'message' => 'Friend not found.',
            ], 404);
        }

        // Cannot add yourself
        if ($friend->id === $userId) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot add yourself.',
            ], 422);
        }

        // Check if friendship already exists in either direction
        $exists = Addfriend::where(function ($q) use ($userId, $friend) {
            $q->where('user_id', $userId)->where('friend_id', $friend->id);
        })->orWhere(function ($q) use ($userId, $friend) {
            $q->where('user_id', $friend->id)->where('friend_id', $userId);
        })->first();

        $friend->loadMissing('profile');
        $friendAvatar = $friend->profile?->image
            ? (str_starts_with($friend->profile->image, 'http')
                ? $friend->profile->image
                : '/storage/' . ltrim($friend->profile->image, '/'))
            : null;

        $friendPayload = [
            'id' => $friend->id,
            'name' => $friend->name,
            'number_id' => $friend->number_id ?? $friend->id,
            'email' => $friend->email,
            'avatar' => $friendAvatar,
            'gender' => $friend->profile?->gender,
            'description' => $friend->profile?->description,
        ];

        if ($exists) {
            return response()->json([
                'success' => true,
                'message' => 'Friend already exists.',
                'chat_id' => $exists->chat_id,
                'friend_id' => $friend->id,
                'friend' => $friendPayload,
                'already_exists' => true,
            ]);
        }

        // Create new chat ID
        $lastChatId = Addfriend::max('chat_id');

        $chatId = $lastChatId
            ? $lastChatId + 1
            : 1;

        $addfriend = Addfriend::create([
            'chat_id' => $chatId,
            'user_id' => $userId,
            'friend_id' => $friend->id,
            'group_name' => '0',
        ]);

        // Invalidate friends cache for both users
        \Illuminate\Support\Facades\Cache::forget("user_friends_{$userId}");
        \Illuminate\Support\Facades\Cache::forget("user_friends_{$friend->id}");

        // Build current user payload for the recipient
        $currentUser = auth()->user() ?? User::find($userId);
        $currentUser->loadMissing('profile');
        $currentUserAvatar = $currentUser->profile?->image
            ? (str_starts_with($currentUser->profile->image, 'http')
                ? $currentUser->profile->image
                : '/storage/' . ltrim($currentUser->profile->image, '/'))
            : null;

        $currentUserPayload = [
            'id' => $currentUser->id,
            'name' => $currentUser->name,
            'number_id' => $currentUser->number_id ?? $currentUser->id,
            'email' => $currentUser->email,
            'avatar' => $currentUserAvatar,
            'gender' => $currentUser->profile?->gender,
            'description' => $currentUser->profile?->description,
        ];

        // Broadcast FriendAdded event to recipient via WebSocket
        try {
            broadcast(new \App\Events\FriendAdded($friend->id, $currentUserPayload, $chatId));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('FriendAdded broadcast failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Friend added successfully.',
            'chat_id' => $addfriend->chat_id,
            'friend_id' => $friend->id,
            'friend' => $friendPayload,
        ]);
    }
}