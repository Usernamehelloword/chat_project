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
        $this->message=$message;
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
}