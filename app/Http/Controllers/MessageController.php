<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Events\NewNotification; // Importe o evento de notificação
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function send(Request $request, User $user)
    {
        $request->validate(['content' => 'required|string|max:1000']);

        // Cria a mensagem
        $message = Message::create([
            'sender_id' => Auth::id(),
            'recipient_id' => $user->id,
            'content' => $request->content,
        ]);

        // Verifica se a conversa está ativa para evitar nova notificação
        $isActiveConversation = ($user->id === session('active_conversation'));

        // Dispara eventos para atualizar a conversa e notificações em tempo real
        broadcast(new MessageSent($message))->toOthers();
        broadcast(new NewNotification($user->id, Auth::id(), $isActiveConversation))->toOthers();

        return response()->json(['message' => $message], 200);
    }

    public function refreshConversations()
    {
        $userId = Auth::id();
        $conversations = Message::where('recipient_id', $userId)
            ->orWhere('sender_id', $userId)
            ->with(['sender', 'recipient'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique(function ($message) use ($userId) {
                return $message->sender_id === $userId ? $message->recipient_id : $message->sender_id;
            });

        foreach ($conversations as $conversation) {
            $otherUserId = $conversation->sender_id === $userId ? $conversation->recipient_id : $conversation->sender_id;
            $conversation->unread_count = Message::where('sender_id', $otherUserId)
                ->where('recipient_id', $userId)
                ->where('is_read', false)
                ->count();
        }

        return response()->json([
            'conversations' => view('messages.partials.inbox-conversations', compact('conversations'))->render()
        ]);
    }




    public function store(Request $request, User $user)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Create and save the message
        $message = Message::create([
            'sender_id' => Auth::id(),
            'recipient_id' => $user->id,
            'content' => $request->content,
        ]);

        // Handle any post-save actions, such as broadcasting an event
        return redirect()->route('messages.conversation', $user->id);
    }

    public function conversation(User $user)
    {
        $userId = Auth::id();

        // Obter as mensagens entre o usuário autenticado e o outro usuário
        $messages = Message::where(function ($query) use ($userId, $user) {
            $query->where('sender_id', $userId)
                ->where('recipient_id', $user->id);
        })->orWhere(function ($query) use ($userId, $user) {
            $query->where('sender_id', $user->id)
                ->where('recipient_id', $userId);
        })->orderBy('created_at', 'asc')->get();

        // Marcar todas as mensagens recebidas como lidas
        Message::where('sender_id', $user->id)
            ->where('recipient_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('messages.conversation', compact('messages', 'user'));
    }


    public function inbox()
    {
        $userId = Auth::id();

        // Get distinct conversations by getting the latest message for each sender/recipient pair
        $conversations = Message::where('recipient_id', $userId)
            ->orWhere('sender_id', $userId)
            ->with(['sender', 'recipient'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique(function ($message) use ($userId) {
                return $message->sender_id === $userId ? $message->recipient_id : $message->sender_id;
            });

        // Get the count of unread messages per conversation
        foreach ($conversations as $conversation) {
            $otherUserId = $conversation->sender_id === $userId ? $conversation->recipient_id : $conversation->sender_id;
            $conversation->unread_count = Message::where('sender_id', $otherUserId)
                ->where('recipient_id', $userId)
                ->where('is_read', false)
                ->count();
        }

        return view('messages.inbox', compact('conversations'));
    }

    public function unreadCount()
    {
        $userId = Auth::id();

        return Message::where('recipient_id', $userId)
            ->where('is_read', false)
            ->count();
    }

    public function markAsReadForConversation(User $user)
    {
        $userId = Auth::id();

        // Marcar todas as mensagens como lidas para a conversa ativa
        Message::where('sender_id', $user->id)
            ->where('recipient_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['status' => 'success']);
    }
}
