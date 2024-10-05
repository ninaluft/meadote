<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Criar Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <x-label for="title" value="{{ __('Título do Post') }}" />
                        <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="content" value="{{ __('Conteúdo') }}" />
                        <div id="quill-editor" class="block mt-1 w-full" style="height: 200px;"></div>
                        <input type="hidden" id="content" name="content" value="{{ old('content') }}" required>
                        @error('content')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="image" value="{{ __('Imagem do Post (opcional)') }}" />
                        <input type="file" id="image" name="image" class="block mt-1 w-full" accept="image/*" onchange="previewImage(event)">
                        @error('image')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <div class="mt-4">
                            <img id="image-preview" class="hidden w-full max-w-xs rounded-lg shadow-md" alt="Pré-visualização da Imagem">
                        </div>
                    </div>

                    <x-button>
                        {{ __('Criar Post') }}
                    </x-button>
                </form>
            </div>
        </div>
    </div>

    <!-- Quill Editor CSS and JS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <!-- Script para inicializar o Quill e pré-visualização da imagem -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Quill editor
            var quill = new Quill('#quill-editor', {
                theme: 'snow',
                placeholder: 'Digite o conteúdo do post aqui...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, false] }],
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'color': [] }, { 'background': [] }],
                        ['link', 'image', 'code-block']
                    ]
                }
            });

            // Set initial content for the editor
            quill.root.innerHTML = `{!! old('content') !!}`;

            // Update the hidden input field whenever the content of Quill editor changes
            quill.on('text-change', function() {
                document.getElementById('content').value = quill.root.innerHTML;
            });
        });

        // Preview uploaded image
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('image-preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
