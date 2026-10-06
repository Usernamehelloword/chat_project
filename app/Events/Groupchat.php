<?php

namespace App\Events;

use App\Models\Groupchatmodel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Groupchat implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public Groupchatmodel $message;

    public function __construct(Groupchatmodel $message)
    {
        $this->message = $message->load('user.profile');
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel(
                'group-chat.' . $this->message->group_id
            ),
        ];
    }

    public function broadcastAs(): string
    {
        return 'group.message.sent';
    }

    public function broadcastWith(): array
    {
        return [
            'message' => [
                'id' => $this->message->id,
                'group_id' => $this->message->group_id,
                'group_name' => $this->message->group_name,
                'user_id' => $this->message->user_id,
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