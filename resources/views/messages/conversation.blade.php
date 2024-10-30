<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
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

    <div class="py-8">
        <div class="flex flex-col max-w-4xl mx-auto h-[80vh]"> <!-- Define a altura da caixa com h-[70vh] -->

            <!-- Container principal de mensagens com rolagem lateral -->
            <div id="messages-container" class="flex-grow overflow-y-auto bg-gray-50 p-6 rounded-t-lg shadow-md h-[55vh]">
                <div class="space-y-4">
                    @if ($messages->isEmpty())
                        <p class="text-gray-500 text-center">{{ __('Você ainda não tem mensagens.') }}</p>
                    @else
                        <ul id="messages-list">
                            @foreach ($messages as $message)
                                <li class="flex {{ $message->sender->id === auth()->id() ? 'justify-end' : 'justify-start' }} mb-4">
                                    <div class="{{ $message->sender->id === auth()->id() ? 'bg-indigo-500 text-white' : 'bg-gray-300 text-gray-800' }} max-w-xs p-4 rounded-2xl shadow-md">
                                        <p class="font-semibold">{{ $message->sender->id === auth()->id() ? 'Você' : $message->sender->name }}</p>
                                        <p class="mt-1">{!! $message->content !!}</p>
                                        <span class="text-xs block mt-2 {{ $message->sender->id === auth()->id() ? 'text-gray-200' : 'text-gray-600' }}">
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
            <div class="bg-white shadow-md p-4 flex items-center space-x-4 w-full rounded-b-lg">
                <!-- Botão de Emoji fora da caixa de texto -->
                <button type="button" id="emoji-btn" class="text-gray-500 hover:text-gray-700 text-2xl">😀</button>

                <form id="sendMessageForm" action="{{ route('messages.send', $user->id) }}" method="POST" class="flex-grow flex items-center">
                    @csrf
                    <textarea id="content" name="content" rows="1" maxlength="900"
                        class="block w-full resize-none rounded-full border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-3"
                        placeholder="Escreva sua mensagem..." required></textarea>
                </form>

                <button type="submit" form="sendMessageForm" class="bg-indigo-500 hover:bg-indigo-600 text-white p-3 rounded-full shadow-md transition duration-150 ease-in-out">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>


    <!-- Script para rolagem automática e carregamento de mensagens -->
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

            Echo.private(channelName)
                .listen('MessageSent', (e) => {
                    const messageElement = document.createElement('li');
                    messageElement.classList.add('flex', e.user.id === userId ? 'justify-end' : 'justify-start',
                        'mb-4');
                    messageElement.innerHTML =
                        `<div class="${e.user.id === userId ? 'bg-indigo-500 text-white' : 'bg-gray-300 text-gray-800'} max-w-xs p-4 rounded-2xl shadow-md"><p class="font-semibold">${e.user.id === userId ? 'Você' : e.user.name}</p><p class="mt-1">${e.message}</p><span class="text-xs block mt-2 ${e.user.id === userId ? 'text-gray-200' : 'text-gray-600'}">${e.created_at}</span></div>`;
                    document.getElementById('messages-list').appendChild(messageElement);
                    scrollToBottom();
                });
        });

        document.querySelector('#sendMessageForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const content = document.querySelector('#content').value;
            const url = this.action;

            axios.post(url, {
                    content
                })
                .then(response => {
                    document.querySelector('#content').value = '';
                    const messageContainer = document.getElementById('messages-list');
                    const messageElement = document.createElement('li');
                    messageElement.classList.add('flex', 'justify-end', 'mb-4');
                    messageElement.innerHTML =
                        `<div class="bg-indigo-500 text-white max-w-xs p-4 rounded-2xl shadow-md"><p class="font-semibold">Você</p><p class="mt-1">${content}</p><span class="text-xs text-gray-200 block mt-2">Agora mesmo</span></div>`;
                    messageContainer.appendChild(messageElement);
                    scrollToBottom();
                })
                .catch(error => {
                    console.error('Erro ao enviar mensagem:', error);
                });
        });
    </script>
</x-app-layout>
