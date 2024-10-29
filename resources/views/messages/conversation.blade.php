<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notificações de ') }}
            @if ($user->email === 'sistema@meadote.com')
                Sistema
            @else
                <a href="{{ route('user.public-profile', $user->id) }}" class="text-indigo-600 hover:underline">
                    {{ $user->name }}
                </a>
            @endif
        </h2>
    </x-slot>


    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6">
                @if ($messages->isEmpty())
                    <p>{{ __('Você ainda não tem mensagens.') }}</p>
                @else
                    <!-- Container com barra de rolagem lateral -->
                    <div id="messages-container" class="overflow-y-auto h-96">
                        <ul>
                            @foreach ($messages as $message)
                                <li class="mb-4">
                                    <strong>{{ $message->sender->name }}:</strong>
                                    <p>{!! $message->content !!}</p>
                                    <span
                                        class="text-xs text-gray-400">{{ $message->created_at->diffForHumans() }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        @if ($user->email !== 'sistema@meadote.com')
            <!-- Exibe o formulário de envio de mensagem apenas se o usuário não for o sistema -->
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg p-6">
                    <form id="sendMessageForm" action="{{ route('messages.send', $user->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700">Mensagem</label>
                            <div class="relative">
                                <textarea id="content" name="content" rows="4" maxlength="900"
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required></textarea>
                                <!-- Botão de Emoji -->
                                <button type="button" id="emoji-btn"
                                    class="absolute right-2 bottom-2 text-gray-500 hover:text-gray-700">
                                    😀
                                </button>
                            </div>

                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Enviar</button>
                    </form>
                </div>
            </div>
        @else
            <!-- Se for uma conversa com o sistema, exibe a mensagem abaixo -->
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg p-6">
                    <p class="text-center text-gray-500">Esta é uma mensagem do sistema. Você não pode responder.</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Script para rolagem automática -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Rolagem automática para o final do histórico de mensagens
            var messagesContainer = document.getElementById('messages-container');
            if (messagesContainer) {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        });
    </script>


    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const userId = {{ auth()->user()->id }};
            const recipientId = {{ $user->id }}; // O usuário destinatário

            // Ordena os IDs para criar o nome do canal
            const channelName = `chat.${Math.min(userId, recipientId)}.${Math.max(userId, recipientId)}`;

            var messagesContainer = document.getElementById('messages-container');

            Echo.private(channelName)
                .listen('MessageSent', (e) => {
                    const messageElement = document.createElement('li');
                    messageElement.innerHTML =
                        `<strong>${e.user.name}:</strong> ${e.message} <span class="text-xs text-gray-400">${e.created_at}</span>`;
                    messagesContainer.appendChild(messageElement);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                });
        });



        document.querySelector('#sendMessageForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Previne o envio padrão do formulário

            const content = document.querySelector('#content').value;
            const url = this.action;

            axios.post(url, {
                    content: content
                })
                .then(response => {
                    // Limpa o campo de texto após o envio
                    document.querySelector('#content').value = '';

                    // Opcional: Adiciona a mensagem ao container de mensagens
                    const messageContainer = document.getElementById('messages-container');
                    const messageElement = document.createElement('li');
                    messageElement.innerHTML = `<strong>Você:</strong> ${content}`;
                    messageContainer.appendChild(messageElement);

                    // Rolagem automática para a nova mensagem
                    messageContainer.scrollTop = messageContainer.scrollHeight;
                })
                .catch(error => {
                    console.error('Erro ao enviar mensagem:', error);
                });
        });
    </script>

</x-app-layout>
