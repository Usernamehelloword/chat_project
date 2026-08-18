<?php

namespace App\Events;

use App\Models\Groupchatmodel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GroupMessageSent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public Groupchatmodel $message;

    public string $groupName;

    public function __construct(
        Groupchatmodel $message,
        string $groupName
    ) {
        $this->message = $message;

        $this->groupName = $groupName;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel(
                'group-chat.' . $this->groupName
            ),
        ];
    }

    public function broadcastAs(): string
    {
        return 'group.message.sent';
    }
}