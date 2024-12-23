<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Events\NewNotification;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Models\AdoptionForm;
use App\Notifications\AdoptionFormSubmitted;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Marcar uma notificação como lida
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        return

            redirect()->back();
    }



    // Enviar notificação como mensagem do sistema

    public function sendSystemNotification($supportRequestId, $userId, $messageContent = null)
    {
        // Obtém o usuário "Sistema"
        $systemUser = User::where('email', 'sistema@meadote.com')->first();

        // Link para detalhes de suporte
        $conversationLink = route('support.show', $supportRequestId);
        $messageContent .= " <a href='{$conversationLink}' class='inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150'>Ver</a>";


        // Cria a mensagem
        $message = Message::create([
            'sender_id' => $systemUser->id,
            'recipient_id' => $userId,
            'content' => $messageContent,
            'is_read' => false,
        ]);

        // Envia o evento para notificação em tempo real
        event(new NewNotification($userId, [
            'type' => 'sistema',
            'content' => $messageContent,
            'sender_id' => $systemUser->id,
            'link' => $conversationLink,
        ]));

        broadcast(new MessageSent($message))->toOthers();

        return $message;
    }

    // Exemplo de uso ao enviar uma notificação
    public function notifyAdoptionRequest($userId, AdoptionForm $adoptionForm)
    {
        $user = User::find($userId);
        $message = "Você recebeu um novo formulário de adoção para o pet {$adoptionForm->pet->name}.";

        // Envia a notificação como mensagem do sistema
        $this->sendSystemNotification($user->id, $message);

        // Envia notificação por email (opcional)
        $user->notify(new AdoptionFormSubmitted($adoptionForm));
    }

    // Mostrar todas as notificações como mensagens no inbox
    public function inbox()
    {
        $userId = Auth::id();

        // Carregar notificações e mensagens
        $notifications = Auth::user()->notifications()->whereNull('read_at')->get();

        $conversations = Message::where('recipient_id', $userId)
            ->orWhere('sender_id', $userId)
            ->with(['sender', 'recipient'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique(function ($message) use ($userId) {
                return $message->sender_id === $userId ? $message->recipient_id : $message->sender_id;
            });

        return view('messages.inbox', compact('conversations', 'notifications'));
    }
}
