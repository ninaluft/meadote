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
                    <!-- Flex container to align the "Create New Post" button to the right -->
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('posts.create') }}"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                            Criar Novo Post
                        </a>
                    </div>
                @endif

                <!-- Search and Sort Form -->
                <form method="GET" action="{{ route('posts.index') }}" class="mb-6" id="searchForm">
                    <div class="flex items-end gap-4">
                        <!-- Search by Title with icon inside input, expands to fill available space -->
                        <div class="relative flex-grow">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Buscar por título"
                                class="w-full pl-4 pr-10 border-gray-300 rounded-lg p-2 focus:border-indigo-500 focus:ring-indigo-500">
                            <button type="submit" class="absolute right-3 top-2 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>

                        <!-- Sort Options with fixed width, aligned to the right -->
                        <div class="relative w-36">
                            <select name="sort" onchange="document.getElementById('searchForm').submit()"
                                class="w-full pl-3 pr-8 border-gray-300 rounded-lg p-2 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Mais Novo</option>
                                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Mais Antigo</option>
                            </select>
                        </div>
                    </div>
                </form>

                <!-- Display Active Filters Summary with Clear Filters Button -->
                @php
                    $activeFilters = [];
                    if (request('search')) {
                        $activeFilters[] = 'Título: ' . request('search');
                    }
                    if (request('sort')) {
                        $activeFilters[] = 'Ordenação: ' . (request('sort') == 'desc' ? 'Mais Novo' : 'Mais Antigo');
                    }
                @endphp

                @if (count($activeFilters) > 0)
                    <div
                        class="mb-6 p-2 bg-teal-50 text-teal-800 rounded-md border border-teal-200 flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div class="mb-2 md:mb-0">
                            <p class="font-semibold">Filtros ativos:</p>
                            <ul class="list-disc list-inside">
                                @foreach ($activeFilters as $filter)
                                    <li>{{ $filter }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- Clear Filters Button -->
                        <a href="{{ route('posts.index') }}"
                            class="mt-2 md:mt-0 px-4 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-600 transition shadow-sm">
                            Limpar Filtros
                        </a>
                    </div>
                @endif

                @if ($posts->isEmpty())
                    <p>Nenhum post encontrado.</p>
                @else
                    <!-- Display grid with 3 cards per row -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($posts as $post)
                            <a href="{{ route('posts.show', $post->id) }}"
                                class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg hover:bg-gray-100 transition duration-300 ease-in-out w-full h-full flex flex-col">

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
                                    <x-image :src="$post->image_path" alt="{{ $post->title }}"
                                        class="w-full h-48 object-cover object-center rounded-lg mb-4" />
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
