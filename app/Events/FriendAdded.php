<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FriendAdded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $recipientId;
    public array $friend;
    public int $chatId;

    public function __construct(int $recipientId, array $friend, int $chatId)
    {
        $this->recipientId = $recipientId;
        $this->friend = $friend;
        $this->chatId = $chatId;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->recipientId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'friend.added';
    }

    public function broadcastWith(): array
    {
        return [
            'friend' => $this->friend,
            'chat_id' => $this->chatId,
        ];
    }
}
