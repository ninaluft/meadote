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
                @if($messages->isEmpty())
                    <p>{{ __('Você ainda não tem mensagens.') }}</p>
                @else
                    <!-- Container com barra de rolagem lateral -->
                    <div id="messages-container" class="overflow-y-auto h-96">
                        <ul>
                            @foreach($messages as $message)
                                <li class="mb-4">
                                    <strong>{{ $message->sender->name }}:</strong>
                                    <p>{!! $message->content !!}</p>
                                    <span class="text-xs text-gray-400">{{ $message->created_at->diffForHumans() }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        @if($user->email !== 'sistema@meadote.com')
            <!-- Exibe o formulário de envio de mensagem apenas se o usuário não for o sistema -->
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg p-6">
                    <form action="{{ route('messages.send', $user->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700">Mensagem</label>
                            <div class="relative">
                                <textarea id="content" name="content" rows="4" maxlength="900"
                                    class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    required oninput="updateCharacterCount()"></textarea>
                                <!-- Botão de Emoji -->
                                <button type="button" id="emoji-btn" class="absolute right-2 bottom-2 text-gray-500 hover:text-gray-700">
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

    <!-- Script para rolagem automática e atualização de caracteres -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Rolagem automática para o final do histórico de mensagens
            var messagesContainer = document.getElementById('messages-container');
            if (messagesContainer) {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        });

        function updateCharacterCount() {
            const content = document.getElementById('content');
            const charCount = document.getElementById('char-count');
            const maxLength = content.getAttribute('maxlength');
            const remaining = maxLength - content.value.length;
            charCount.textContent = `${remaining} caracteres restantes`;
        }
    </script>
</x-app-layout>
