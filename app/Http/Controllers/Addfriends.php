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

        // Check this exact friendship
        $exists = Addfriend::where('user_id', $userId)
            ->where('friend_id', $friend->id)
            ->first();

        if ($exists) {
            return response()->json([
                'success' => true,
                'message' => 'Friend already exists.',
                'chat_id' => $exists->chat_id,
                'friend_id' => $friend->id,
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

        return response()->json([
            'success' => true,
            'message' => 'Friend added successfully.',
            'chat_id' => $addfriend->chat_id,
            'friend_id' => $friend->id,
        ]);
    }
}