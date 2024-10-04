<?php

namespace App\Http\Controllers;

use App\Models\SupportRequest;
use App\Models\SupportMessage;
use App\Models\User;
use App\Notifications\NewSupportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationController;


class SupportRequestController extends Controller
{
    // List user's support requests
    public function index()
    {
        $supportRequests = Auth::user()->supportRequests;
        return view('support.index', compact('supportRequests'));
    }

    // Show form to create a new support request
    public function create()
    {
        return view('support.create');
    }

    public function sendSystemNotification($supportRequestId, $userId, $messageContent)
    {
        // Obtém o usuário "Sistema"
        $systemUser = User::where('email', 'sistema@meadote.com')->first();


        // Cria a mensagem no inbox como se fosse enviada pelo sistema
        SupportMessage::create([
            'support_request_id' => $supportRequestId,  // Define o ID da solicitação de suporte
            'user_id' => $systemUser->id,  // Usuário "Sistema"
            'message' => $messageContent,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


    }



    // Store new support request
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $supportRequest = SupportRequest::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'status' => 'open',
        ]);

        $supportRequest->messages()->create([
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        // Notificar administradores
        $admins = User::where('user_type', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewSupportRequest($supportRequest)); // Certifique-se que este caminho está correto
        }

        return redirect()->route('support.index')->with('status', 'Sua solicitação foi enviada com sucesso.');
    }


    // Show details of a support request (chat)
    public function show(SupportRequest $supportRequest)
    {
        if (Auth::id() !== $supportRequest->user_id && Auth::user()->user_type !== 'admin') {
            abort(403);
        }

        $messages = $supportRequest->messages()->orderBy('created_at')->get();
        return view('support.show', compact('supportRequest', 'messages'));
    }

    // Send message in support request chat
    public function sendMessage(Request $request, SupportRequest $supportRequest)
    {
        $request->validate(['message' => 'required|string']);

        // Verifica se a solicitação foi encerrada
        if ($supportRequest->status === 'closed') {
            if (auth()->user()->user_type === 'admin') {
                return redirect()->route('admin.support.details', $supportRequest)->with('error', 'Esta solicitação de suporte foi encerrada.');
            } else {
                return redirect()->route('support.show', $supportRequest)->with('error', 'Esta solicitação de suporte foi encerrada.');
            }
        }

        // Cria uma nova mensagem no chat da solicitação de suporte
        SupportMessage::create([
            'support_request_id' => $supportRequest->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        // Enviar notificação para o solicitante quando o admin responde
        if (auth()->user()->user_type === 'admin') {
            $notificationController = new NotificationController();

            $messageContent = "Você recebeu uma nova resposta do administrador na solicitação de suporte '{$supportRequest->subject}'.";

            // Envia a notificação com o ID correto da solicitação de suporte
            $notificationController->sendSystemNotification($supportRequest->id, $supportRequest->user_id, $messageContent);
        }

        // Redireciona de acordo com o tipo de usuário
        if (auth()->user()->user_type === 'admin') {
            // Redirecionar o administrador para a rota correta
            return redirect()->route('admin.support.details', $supportRequest)->with('status', 'Mensagem enviada com sucesso.');
        } else {
            // Redirecionar o usuário comum para a rota correta
            return redirect()->route('support.show', $supportRequest)->with('status', 'Mensagem enviada com sucesso.');
        }
    }






    // Admin closes the support request
    public function close(SupportRequest $supportRequest)
    {
        // Atualiza o status da solicitação para "fechado"
        $supportRequest->update(['status' => 'closed']);

        // Enviar notificação para o solicitante informando que a solicitação foi fechada
        $notificationController = new NotificationController();
        $messageContent = "Sua solicitação de suporte '{$supportRequest->subject}' foi encerrada pelo administrador.";

        // Chama o método para enviar a notificação com o ID da solicitação e do usuário solicitante
        $notificationController->sendSystemNotification($supportRequest->id, $supportRequest->user_id, $messageContent);

        // Redireciona o administrador para a página correta com mensagem de status
        return redirect()->route('admin.support.show', $supportRequest)->with('status', 'Solicitação de suporte encerrada.');
    }



    public function adminIndex(Request $request)
    {
        // Defina o campo de ordenação padrão
        $sort = $request->get('sort', 'created_at'); // Ordenar por 'created_at' por padrão
        $direction = $request->get('direction', 'desc'); // Ordenar por 'desc' por padrão

        // Query para buscar os pedidos de suporte com ordenação
        $supportRequests = SupportRequest::orderBy($sort, $direction)->paginate(10);

        // Passar os dados para a view
        return view('admin.support.index', compact('supportRequests', 'sort', 'direction'));
    }




    public function showSupportRequestDetails(SupportRequest $supportRequest)
    {
        // Fetch messages related to the support request
        $messages = $supportRequest->messages()->orderBy('created_at')->get();

        // Return the view with the support request and messages
        return view('support.details', compact('supportRequest', 'messages'));
    }


    public function adminShow(SupportRequest $supportRequest)
    {
        // Verifique se o usuário autenticado é um administrador
        if (auth()->user()->user_type !== 'admin') {
            abort(403, 'Acesso não autorizado.');
        }

        // Obtenha todas as mensagens relacionadas ao pedido de suporte
        $messages = $supportRequest->messages()->orderBy('created_at')->get();

        // Retorne a view para o admin gerenciar o pedido de suporte
        return view('admin.support.show', compact('supportRequest', 'messages'));
    }
}
