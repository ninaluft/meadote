<?php

namespace App\Notifications;

use App\Models\SupportRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewSupportRequest extends Notification
{
    use Queueable;

    protected $supportRequest;

    public function __construct(SupportRequest $supportRequest)
    {
        $this->supportRequest = $supportRequest;
    }

    public function via($notifiable)
    {
        return ['database']; // Notificação por banco de dados
    }

    public function toArray($notifiable)
    {
        // Verifique se o usuário é um admin e defina a rota correta
        $route = $notifiable->user_type === 'admin'
            ? route('admin.support.details', $this->supportRequest->id)
            : route('support.details', $this->supportRequest->id);

        return [
            'support_request_id' => $this->supportRequest->id,
            'user_name' => $this->supportRequest->user->name,
            'subject' => $this->supportRequest->subject,
            'route' => $route, // Adicionando a chave 'route'
        ];
    }
}
