<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mensagens') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6">
                @if($conversations->isEmpty())
                    <p>{{ __('Você ainda não tem conversas.') }}</p>
                @else
                    <!-- Função para pegar as iniciais do nome -->
                    @php
                        $getInitials = function($name) {
                            $words = explode(' ', $name);
                            $initials = '';
                            foreach ($words as $word) {
                                $initials .= strtoupper(substr($word, 0, 1));
                            }
                            return substr($initials, 0, 2);
                        };
                    @endphp

                    <!-- Container para rolagem lateral com altura aumentada -->
                    <div class="overflow-y-auto h-[450px]">
                        <ul>
                            @foreach($conversations as $conversation)
                                @php
                                    // Obter o usuário "Sistema" pelo e-mail
                                    $systemUser = \App\Models\User::where('email', 'sistema@meadote.com')->first();

                                    // Verifica se é uma mensagem do sistema
                                    $isSystemMessage = $conversation->sender_id === $systemUser->id;

                                    // Define o usuário "Sistema" ou outro usuário na conversa
                                    $otherUser = $isSystemMessage
                                        ? (object) ['id' => $systemUser->id, 'name' => 'Sistema']
                                        : ($conversation->sender_id === Auth::id() ? $conversation->recipient : $conversation->sender);
                                @endphp

                                <!-- Se o otherUser for nulo, continue para a próxima iteração -->
                                @if (!$otherUser)
                                    @continue
                                @endif

                                <li class="mb-2 flex items-center">
                                    <!-- Espaço reservado para alinhar corretamente as mensagens do sistema -->
                                    @if($isSystemMessage)
                                        <div class="w-10 h-10 mr-3"></div>
                                    @else
                                        <!-- Exibir iniciais do usuário -->
                                        <div class="w-10 h-10 mr-3 flex items-center justify-center bg-gray-500 text-white font-medium rounded-full">
                                            <span class="text-sm">{{ $getInitials($otherUser->name) }}</span>
                                        </div>
                                    @endif

                                    <!-- Informações da conversa com altura reduzida -->
                                    <a href="{{ route('messages.conversation', $otherUser->id) }}" class="flex-1 p-3 bg-gray-50 border bg-gray-100' hover:bg-gray-100 rounded-lg" aria-label="Conversa com {{ $otherUser->name }}">
                                        <h3 class="text-base font-semibold flex items-center justify-between">
                                            <span>{{ $otherUser->name }}</span>
                                            <!-- Mostrar contador de mensagens não lidas, se houver -->
                                            @if($conversation->unread_count > 0)
                                                <span class="ml-2 inline-block bg-red-600 text-white text-xs rounded-full px-2 py-1">
                                                    {{ $conversation->unread_count }}
                                                </span>
                                            @endif
                                        </h3>
                                        <p class="text-xs text-gray-600">{{ \Illuminate\Support\Str::limit($conversation->content, 50) }}</p>
                                        <span class="text-xs text-gray-400">{{ $conversation->created_at->diffForHumans() }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
