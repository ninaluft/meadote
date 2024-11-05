<x-app-layout :hideFooter="true">

    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight text-center sm:text-left">
            Conversa com
            @if ($user->email === 'sistema@meadote.com')
                Sistema
            @else
                <a href="{{ route('user.public-profile', $user->id) }}" class="text-indigo-600 hover:underline">
                    {{ $user->name }}
                </a>
            @endif
        </h2>
    </x-slot>


    <!-- Container principal para ajustar a altura total da tela -->
    <div class="flex flex-col mt-2 max-w-full sm:max-w-4xl mx-auto" style="height: 75vh;">

        <!-- Contêiner que segura o conteúdo principal e a barra de envio -->
        <div class="flex flex-col w-full h-full sm:w-[90%] mx-auto">

            <!-- Contêiner de mensagens, com altura ajustada para ocupar o espaço restante -->
            <div id="messages-container" class="flex-grow overflow-y-auto bg-gray-50 p-4 rounded-t-lg shadow-md ">
                <div class="space-y-4">
                    @if ($messages->isEmpty())
                        <p class="text-gray-500 text-center">{{ __('Você ainda não tem mensagens.') }}</p>
                    @else
                        <ul id="messages-list" class="space-y-2 sm:space-y-3">
                            @foreach ($messages as $message)
                                <li
                                    class="flex {{ $message->sender->id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                    <div
                                        class="message {{ $message->sender->id === auth()->id() ? 'sent' : 'received' }} max-w-[85%] sm:max-w-md p-3 rounded-lg shadow-md text-sm sm:text-base">
                                        <p class="font-semibold">
                                            {{ $message->sender->id === auth()->id() ? 'Você' : $message->sender->name }}
                                        </p>
                                        <p class="mt-1 break-words">{!! $message->content !!}</p>
                                        <span
                                            class="text-xs block mt-1 {{ $message->sender->id === auth()->id() ? 'text-gray-200' : 'text-gray-600' }}">
                                            {{ $message->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <!-- Barra fixa de envio de mensagem -->
            @if ($user->email !== 'sistema@meadote.com')
                <div id="sendBar" class="bg-white shadow-md p-2 flex items-center space-x-2 sm:space-x-4 w-full"
                    style="height: 60px; position: sticky; bottom: 0;">
                    <button type="button" id="emoji-btn"
                        class="text-gray-500 hover:text-gray-700 text-xl sm:text-2xl">😀</button>
                    <form id="sendMessageForm" action="{{ route('messages.send', $user->id) }}" method="POST"
                        class="flex-grow flex items-center">
                        @csrf
                        <textarea id="content" name="content" rows="1" maxlength="900"
                            class="block w-full resize-none rounded-2xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 text-base sm:text-base"
                            placeholder="Escreva sua mensagem..." required></textarea>
                    </form>
                    <button type="submit" form="sendMessageForm" id="sendButton"
                        class="bg-indigo-500 hover:bg-indigo-600 text-white p-2 rounded-full shadow-md transition duration-150 ease-in-out text-sm sm:text-base">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            @else
                <!-- Mensagem do sistema -->
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white shadow-xl sm:rounded-lg p-6">
                        <p class="text-center text-gray-500">Esta é uma mensagem do sistema. Você não pode
                            responder.</p>
                    </div>
                </div>
            @endif

        </div>
    </div>


    <!-- Estilos adicionais para mensagens enviadas e recebidas -->
    <style>

        .message.sent {
            background-color: #6b63f5;
            color: white;
            text-align: right;
            border-radius: 15px 15px 5px 15px;
            word-break: break-word;
        }

        .message.received {
            background-color: #e5e7eb;
            color: black;
            text-align: left;
            border-radius: 15px 15px 15px 5px;
            word-break: break-word;
        }

        #messages-container {
            flex-grow: 1;
            overflow-y: auto;
            padding-bottom: 70px;
        }

        /* Ajusta para que a barra de envio fique fixa ao fundo em telas menores */
        @media (max-width: 640px) {
            #sendBar {
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
            }

            #messages-container {
                padding-bottom: 120px;
                /* Espaço adicional para dispositivos móveis */
            }
        }
    </style>

    <!-- Scripts -->
    <script>
        function scrollToBottom() {
            const messagesContainer = document.getElementById('messages-container');
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        document.addEventListener('DOMContentLoaded', function() {
            scrollToBottom();

            const userId = {{ auth()->user()->id }};
            const recipientId = {{ $user->id }};
            const channelName = `chat.${Math.min(userId, recipientId)}.${Math.max(userId, recipientId)}`;

            setActiveConversationUserId(recipientId);

            axios.post(`/conversations/${recipientId}/mark-as-read`)
                .then(response => console.log("Conversa marcada como lida"))
                .catch(error => console.error("Erro ao marcar a conversa como lida:", error));

            Echo.private(channelName)
                .listen('MessageSent', (e) => {
                    if (e.user.id === recipientId) {
                        axios.post(`/conversations/${recipientId}/mark-as-read`)
                            .then(response => console.log("Mensagem marcada como lida"))
                            .catch(error => console.error("Erro ao marcar a mensagem como lida:", error));
                    }

                    const messageElement = document.createElement('li');
                    messageElement.classList.add('flex', e.user.id === userId ? 'justify-end' : 'justify-start',
                        'mb-4');
                    messageElement.innerHTML = `
                    <div class="message ${e.user.id === userId ? 'sent' : 'received'} max-w-xs p-4 rounded-lg shadow-md">
                        <p class="font-semibold">${e.user.id === userId ? 'Você' : e.user.name}</p>
                        <p class="mt-1">${e.message}</p>
                        <span class="text-xs block mt-2 ${e.user.id === userId ? 'text-gray-200' : 'text-gray-600'}">${e.created_at}</span>
                    </div>`;
                    document.getElementById('messages-list').appendChild(messageElement);
                    scrollToBottom();
                });
        });

        document.querySelector('#sendMessageForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const sendButton = document.getElementById('sendButton');
            sendButton.disabled = true;

            const content = document.querySelector('#content').value;
            const messageContainer = document.getElementById('messages-list');

            const messageElement = document.createElement('li');
            messageElement.classList.add('flex', 'justify-end', 'mb-4');
            messageElement.innerHTML = `
            <div class="message sent max-w-xs p-3 rounded-lg shadow-md">
                <p class="font-semibold">Você</p>
                <p class="mt-1">${content}</p>
                <span class="text-xs text-gray-200 block mt-2">Agora mesmo</span>
            </div>`;
            messageContainer.appendChild(messageElement);
            scrollToBottom();

            document.querySelector('#content').value = '';

            axios.post(this.action, {
                    content
                })
                .then(response => {})
                .catch(error => {
                    messageContainer.removeChild(messageElement);
                    console.error('Erro ao enviar mensagem:', error);
                })
                .finally(() => sendButton.disabled = false);
        });
    </script>



</x-app-layout>
