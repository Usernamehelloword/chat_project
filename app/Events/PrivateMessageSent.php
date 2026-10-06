<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Textprivaye;
class PrivateMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

     public Textprivaye $message;
    public function __construct(Textprivaye $message)
    {
        $this->message = $message->load('user.profile');
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel(
                'chat.'.$this->message->chat_id
            )
        ];
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }

    public function broadcastWith(): array
    {
        return [
            'message' => [
                'id' => $this->message->id,
                'chat_id' => $this->message->chat_id,
                'user_id' => $this->message->user_id,
                'friend_id' => $this->message->friend_id,
                'message' => $this->message->message,
                'media_path' => $this->message->media_path,
                'media_type' => $this->message->media_type,
                'created_at' => $this->message->created_at,
                'user' => [
                    'id' => $this->message->user?->id,
                    'name' => $this->message->user?->name,
                    'profile' => [
                        'image' => $this->message->user?->profile?->image,
                    ],
                ],
            ],
        ];
    }
}