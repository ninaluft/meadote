<?php

// App\Events\MessageSent.php
namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\PrivateChannel;
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
        // Ordena os IDs para que o nome do canal seja consistente
        $ids = [$this->message->sender_id, $this->message->recipient_id];
        sort($ids);

        return new PrivateChannel('chat.' . implode('.', $ids));
    }



    public function broadcastWith()
    {
        return [
            'message' => $this->message->content,
            'user' => [
                'id' => $this->message->sender->id,
                'name' => $this->message->sender->name,
            ],
            'created_at' => $this->message->created_at->diffForHumans(),
        ];
    }
}
