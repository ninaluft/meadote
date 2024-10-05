<x-app-layout>

    <div class="py-8 bg-gray-100">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8"> <!-- Ajuste para reduzir a largura máxima -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-10">

                <!-- Botões de Ação (Editar e Excluir) -->
                @if (Auth::check() && Auth::user()->user_type === 'admin')
                    <div class="flex justify-end space-x-4 mb-4"> <!-- Alinhar os botões à direita acima do título -->
                        <!-- Botão de Editar -->
                        <a href="{{ route('posts.edit', $post->id) }}"
                           class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md">
                            {{ __('Editar') }}
                        </a>

                        <!-- Botão de Excluir -->
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Tem certeza de que deseja excluir este post?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-md">
                                {{ __('Excluir') }}
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Título do Post e Autor -->
                <div class="mb-4">
                    <h3 class="text-2xl font-bold">{{ $post->title }}</h3>
                    <p class="text-gray-600">Por {{ $post->author->name }} em {{ $post->created_at->format('d/m/Y') }}</p>
                </div>

                <!-- Imagem do Post -->
                @if ($post->image_path)
                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="w-full h-auto rounded-lg mb-4">
                @endif

                <!-- Renderizando o conteúdo HTML do Quill -->
                <div class="ql-editor text-lg text-gray-800 leading-relaxed"> <!-- Adicionei 'ql-editor' para estilo -->
                    {!! $post->content !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
