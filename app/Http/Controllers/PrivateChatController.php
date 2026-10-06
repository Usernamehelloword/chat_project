<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Textprivaye;
use App\Events\PrivateMessageSent;

class PrivateChatController extends Controller
{
    // Load old messages when clicking a friend
   // Open chat and get messages

    public function openChat(Request $request)
    {
        $request->validate([
            'friend_id' => 'required|integer|exists:users,id',
        ]);

        $chatId = $this->getChatId(
            auth()->id(),
            $request->friend_id
        );

        $messages = Textprivaye::where('chat_id', $chatId)
            ->with(['user.profile'])
            ->orderBy('created_at', 'asc')
            ->get();

        $friendId = (int) $request->friend_id;
        $friend = \Illuminate\Support\Facades\Cache::remember("user_profile_{$friendId}", 3600, function () use ($friendId) {
            return \App\Models\User::with('profile')->find($friendId);
        });

        return response()->json([
            'chat_id'  => $chatId,
            'messages' => $messages,
            'friend'   => $friend
        ]);
    }



    // Send message
    public function sendMessage(Request $request)
    {

        $request->validate(array_merge([
            'friend_id' => 'required|exists:users,id',
        ], $this->chatMessageRules()));

        $chatId = $this->getChatId(
            auth()->id(),
            $request->friend_id
        );

        $media = $this->storeChatMedia($request, 'private');

        $message = Textprivaye::create([
            'user_id'    => auth()->id(),
            'friend_id'  => $request->friend_id,
            'chat_id'    => $chatId,
            'message'    => (string) ($request->message ?? ''),
            'media_path' => $media['media_path'],
            'media_type' => $media['media_type'],
        ]);

        $message->load('user.profile');

        try {
            broadcast(new PrivateMessageSent($message))
                ->toOthers();
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Private chat broadcast failed: ' . $e->getMessage());
        }

        return response()->json([
            'message'=>$message
        ]);

    }

    // Create/find chat id
    private function getChatId(int $user1, int $user2)
    {

        $chat = Textprivaye::where(function($q) use($user1,$user2){
            $q->where('user_id',$user1)
              ->where('friend_id',$user2);
        })

        ->orWhere(function($q) use($user1,$user2){
            $q->where('user_id',$user2)
              ->where('friend_id',$user1);
        })
        ->first();
        if ($chat) {
            return (int) $chat->chat_id;
        }

        $min = min($user1, $user2);
        $max = max($user1, $user2);
        return (int) ($min * 100000 + $max);
    }


}