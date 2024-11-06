<ul>
    @foreach($conversations as $conversation)
        @php
            $systemUser = \App\Models\User::where('email', 'sistema@meadote.com')->first();
            $isSystemMessage = $conversation->sender_id === $systemUser->id;
            $otherUser = $isSystemMessage
                ? (object) ['id' => $systemUser->id, 'name' => 'Sistema']
                : ($conversation->sender_id === Auth::id() ? $conversation->recipient : $conversation->sender);
        @endphp

        @if (!$otherUser)
            @continue
        @endif

        <li class="mb-2 flex items-center">
            @if($isSystemMessage)
                <div class="w-10 h-10 mr-3"></div>
            @else
                <!-- Verifique se o usuário tem uma foto de perfil -->
                <div class="w-10 h-10 mr-3 flex items-center justify-center bg-gray-500 text-white font-medium rounded-full overflow-hidden">
                    @if($otherUser->profile_photo)
                        <img src="{{ asset($otherUser->profile_photo) }}" alt="{{ $otherUser->name }}" class="w-full h-full object-cover rounded-full">
                    @else
                        <span class="text-sm">{{ strtoupper(substr($otherUser->name, 0, 2)) }}</span>
                    @endif
                </div>
            @endif

            <a href="{{ route('messages.conversation', $otherUser->id) }}" class="flex-1 p-3 bg-gray-50 border hover:bg-gray-100 rounded-lg" aria-label="Conversa com {{ $otherUser->name }}">
                <h3 class="text-base font-semibold flex items-center justify-between">
                    <span>{{ $otherUser->name }}</span>
                    @if($conversation->unread_count > 0)
                        <span class="ml-2 inline-block bg-red-600 text-white text-xs rounded-full px-2 py-1">
                            {{ $conversation->unread_count }}
                        </span>
                    @endif
                </h3>
                <p class="text-xs text-gray-600">{{ \Illuminate\Support\Str::limit($conversation->content, 20) }}</p>
                <span class="text-xs text-gray-400">{{ $conversation->created_at->diffForHumans() }}</span>
            </a>
        </li>
    @endforeach
</ul>
