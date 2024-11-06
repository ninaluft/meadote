<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewNotification implements ShouldBroadcast
{
    public $userId;
    public $senderId;
    public $isActiveConversation;

    public function __construct($userId, $senderId, $isActiveConversation = false)
    {
        $this->userId = $userId;
        $this->senderId = $senderId;
        $this->isActiveConversation = $isActiveConversation;
    }

    public function broadcastOn()
    {
        return new Channel('notifications-channel-' . $this->userId);
    }

    public function broadcastAs()
    {
        return 'NewNotification';
    }

    public function broadcastWith()
    {
        $unreadCount = 0;

        // Somente conte notificações se a conversa não estiver ativa
        if (!$this->isActiveConversation) {
            $unreadCount = User::find($this->userId)
                ->unreadMessages()
                ->where('is_read', false)
                ->count();
        }

        return [
            'newCount' => $unreadCount,
            'senderId' => $this->senderId,
        ];
    }
}
