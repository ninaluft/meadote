<x-app-layout>

    <div class="py-8 bg-gray-100">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-10">

                <!-- Botões de Ação (Editar e Excluir) -->
                <div class="flex justify-end mb-4 space-x-4">
                    @if (Auth::check() && Auth::user()->user_type === 'admin')
                        <!-- Botão de Editar -->
                        <x-button-edit href="{{ route('posts.edit', $post->id) }}"
                            aria-label="Editar o post {{ $post->title }}"> <!-- 'aria-label' para acessibilidade -->
                            {{ __('Editar') }}
                        </x-button-edit>

                        <!-- Botão de Excluir -->
                        <x-button-delete action="{{ route('posts.destroy', $post->id) }}"
                            confirmMessage="Tem certeza de que deseja excluir este post?"
                            aria-label="Excluir o post {{ $post->title }}"> <!-- 'aria-label' para acessibilidade -->
                            {{ __('Excluir') }}
                        </x-button-delete>
                    @endif
                </div>

                <!-- Título do Post e Autor -->
                <div class="mb-4">
                    <h3 class="text-2xl font-bold">{{ $post->title }}</h3>
                    <p class="text-gray-600">Por {{ $post->author->name }} em {{ $post->created_at->format('d/m/Y') }}
                    </p>
                </div>

                <!-- Imagem do Post -->
                @if ($post->image_path)
                    <x-image :src="$post->image_path" alt="{{ $post->title }}" class="w-full h-auto rounded-lg" />
                @endif


                <!-- Renderizando o conteúdo HTML do Quill -->
                <div class="ql-editor text-lg text-gray-800 leading-relaxed">
                    {!! $post->content !!}
                </div>

                <!-- Botão de Compartilhar -->
                <div class="mt-6">
                    <x-button-share id="sharePostButton" title="{{$post->title}}"
                        text="Confira esse post: "
                        url="{{ route('posts.show', $post->id) }}"
                        aria-label="Compartilhar o post {{ $post->title }}">
                        {{ __('Compartilhar') }}
                    </x-button-share>
                </div>

                <div class="py-12">
                    <!-- Sessão de Comentários -->
                    <div class="mt-8">
                        <h3 class="text-xl font-bold">Comentários</h3>

                        <!-- Seção de Comentários com Barra de Rolagem -->
                        <div class="space-y-4 mt-4 max-h-80 overflow-y-scroll">
                            @foreach ($post->comments as $comment)
                                <div class="bg-gray-100 p-4 rounded-lg relative">
                                    <p class="text-sm text-gray-600">
                                        <strong>{{ $comment->user->name }}</strong> comentou em
                                        {{ $comment->created_at->format('d/m/Y H:i') }}:
                                    </p>
                                    <p class="mt-2">{{ $comment->content }}</p>

                                    <!-- Excluir comentário (somente autor ou admin) -->
                                    @if (Auth::check() && (Auth::user()->id === $comment->user_id || Auth::user()->user_type === 'admin'))
                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                            onsubmit="return confirm('Tem certeza de que deseja excluir este comentário?');"
                                            class="absolute top-4 right-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800"
                                                title="Excluir comentário" aria-label="Excluir comentário">
                                                <!-- Tooltip e aria-label para acessibilidade -->
                                                <i class="fas fa-trash"></i> <!-- Ícone de lixeira do Font Awesome -->
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Formulário para adicionar novo comentário (somente usuários logados) -->
                        @auth
                            <div class="mt-6">
                                <h4 class="text-lg font-semibold" id="leaveCommentLabel">Deixe seu comentário</h4>
                                <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mt-4"
                                    aria-labelledby="leaveCommentLabel">
                                    @csrf
                                    <textarea name="content" rows="3" class="w-full border-gray-300 rounded-lg p-2"
                                        placeholder="Escreva seu comentário..." aria-describedby="commentHelper"></textarea>
                                    @error('content')
                                        <p class="text-red-500 text-sm mt-1" id="commentHelper">{{ $message }}</p>
                                    @enderror
                                    <button type="submit"
                                        class="mt-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Comentar</button>
                                </form>
                            </div>
                        @else
                            <p class="mt-4 text-gray-500">Você precisa <a href="{{ route('login') }}"
                                    class="text-blue-500">fazer login</a> para comentar.</p>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
