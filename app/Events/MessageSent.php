<?php

// App\Events\MessageSent.php
namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        // Canal privado
        return new PrivateChannel('chat.' . $this->message->recipient_id);
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message->content,
            'user' => [
                'id' => $this->message->sender->id,
                'name' => $this->message->sender->name,
            ]
        ];
    }
}
