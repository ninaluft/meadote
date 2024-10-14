<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts do Blog') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#e7edee] overflow-hidden shadow-xl sm:rounded-lg p-6">

                @if (Auth::check() && Auth::user()->user_type === 'admin')
                    <!-- Flex container para alinhar o botão à direita -->
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('posts.create') }}"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                            Criar Novo Post
                        </a>
                    </div>
                @endif

                <!-- Formulário de busca e ordenação -->
                <form method="GET" action="{{ route('posts.index') }}" class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <!-- Busca por título com col-span-2 para aumentar a largura -->
                        <div class="md:col-span-2">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Buscar por título" class="w-full border-gray-300 rounded-lg p-2">
                        </div>
                        <!-- Ordenação -->
                        <div>
                            <select name="sort" class="w-full border-gray-300 rounded-lg p-2">
                                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Mais Novo
                                </option>
                                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Mais Antigo
                                </option>
                            </select>
                        </div>
                        <!-- Botão de busca -->
                        <div>
                            <x-button class="w-full sm:w-auto h-full">{{ __('Buscar') }}</x-button>
                        </div>
                    </div>
                </form>



                @if ($posts->isEmpty())
                    <p>Nenhum post encontrado.</p>
                @else
                    <!-- Alterar o grid para exibir 3 cards por linha -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($posts as $post)
                            <a href="{{ route('posts.show', $post->id) }}"
                                class="block bg-white p-6 rounded-lg shadow-md hover:shadow-lg hover:bg-gray-100 transition duration-300 ease-in-out w-full h-full flex flex-col">

                                <!-- Container do título e autor com altura mínima para alinhar os títulos -->
                                <div class="mb-4 flex-grow">
                                    <h3 class="text-2xl font-bold text-gray-800 min-h-[100px]">
                                        {{ $post->title }}
                                    </h3>
                                    <p class="text-gray-600">
                                        Por {{ $post->author->name }} em {{ $post->created_at->format('d/m/Y') }}
                                    </p>
                                </div>

                                <!-- Imagem - Alinhamento da imagem com altura fixa -->
                                @if ($post->image_path)
                                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}"
                                        class="w-full h-48 object-cover object-center rounded-lg mb-4">
                                @endif

                                <!-- Texto do post com altura mínima -->
                                <div class="text-gray-700 min-h-[80px]">
                                    {!! \Illuminate\Support\Str::limit($post->content, 100) !!}
                                </div>

                            </a>
                        @endforeach
                    </div>
                @endif

                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
