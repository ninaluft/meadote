<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts do Blog') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#d4e2e4] overflow-hidden shadow-xl sm:rounded-lg p-6">

                @if (Auth::check() && Auth::user()->user_type === 'admin')
                    <a href="{{ route('posts.create') }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg mb-4 inline-block hover:bg-blue-600">
                        Criar Novo Post
                    </a>
                @endif

                @if ($posts->isEmpty())
                    <p>Nenhum post encontrado.</p>
                @else
                    <!-- Alterar o grid para uma única coluna -->
                    <div class="grid grid-cols-1 gap-6">
                        @foreach ($posts as $post)
                            <a href="{{ route('posts.show', $post->id) }}"
                                class="block bg-white p-6 rounded-lg shadow-md hover:shadow-lg hover:bg-gray-100 transition duration-300 ease-in-out w-full">
                                <div class="mb-4 "> <!-- Definindo uma altura fixa para o título e autor -->
                                    <h3 class="text-2xl font-bold text-gray-800">{{ $post->title }}</h3>
                                    <p class="text-gray-600">Por {{ $post->author->name }} em
                                        {{ $post->created_at->format('d/m/Y') }}</p>
                                </div>
                                @if ($post->image_path)
                                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}"
                                        class="w-full h-64 object-cover rounded-lg mb-4"> <!-- Ajuste da altura da imagem -->
                                @endif
                                <div class="text-gray-700">{!! \Illuminate\Support\Str::limit($post->content, 100) !!}</div>
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
