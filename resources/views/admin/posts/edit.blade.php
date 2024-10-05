<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Post') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-10">
                <h3 class="text-2xl font-bold mb-4">{{ __('Editar Post') }}</h3>

                <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" id="post-form">
                    @csrf
                    @method('PUT')

                    <!-- Campo Título -->
                    <div class="mb-4">
                        <x-label for="title" value="{{ __('Título') }}" />
                        <x-input id="title" class="block mt-1 w-full" type="text" name="title"
                            value="{{ old('title', $post->title) }}" required />
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Campo Conteúdo (Editor Quill) -->
                    <div class="mb-4">
                        <x-label for="content" value="{{ __('Conteúdo') }}" />
                        <div id="editor" class="block mt-1 w-full bg-white border border-gray-300 rounded"></div>
                        <textarea id="content" name="content" class="hidden" required>{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Campo Imagem -->
                    <div class="mb-4">
                        <x-label for="image" value="{{ __('Imagem') }}" />
                        @if ($post->image_path)
                            <div class="mb-2">
                                <img id="current-image" src="{{ asset('storage/' . $post->image_path) }}"
                                    alt="{{ $post->title }}" class="w-full h-auto rounded-lg">
                            </div>
                        @endif
                        <input type="file" name="image" id="image" class="form-control" accept="image/*"
                            onchange="previewImage(event)">
                        @error('image')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <div class="mt-4">
                            <img id="image-preview" class="hidden w-full max-w-xs rounded-lg shadow-md"
                                alt="Pré-visualização da Imagem">
                        </div>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex space-x-4">
                        <x-button>{{ __('Salvar Alterações') }}</x-button>
                        <a href="{{ route('posts.show', $post->id) }}"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-md">
                            {{ __('Cancelar') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script para pré-visualização da imagem -->
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('image-preview');
            const currentImage = document.getElementById('current-image');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (currentImage) {
                        currentImage.classList.add('hidden');
                    }
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <!-- Script para inicializar o Quill e transferir o conteúdo para o campo de texto -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inicializa o editor Quill
            var quill = new Quill('#editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, false] }],
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['link', 'blockquote', 'code-block'],
                        [{ 'color': [] }, { 'background': [] }],
                        ['clean']
                    ]
                }
            });

            // Carrega o conteúdo existente
            quill.root.innerHTML = `{!! old('content', $post->content) !!}`;

            // Ao enviar o formulário, copia o conteúdo do Quill para o textarea
            document.getElementById('post-form').addEventListener('submit', function () {
                document.getElementById('content').value = quill.root.innerHTML;
            });
        });
    </script>
</x-app-layout>
