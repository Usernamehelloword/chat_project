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
        $this->message = $message->load('user');
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
            'message' => $this->message,
        ];
    }
}