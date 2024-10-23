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

                <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data"
                    id="post-form">
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
                                @if ($post->image_path)
                                    <x-image :src="$post->image_path" alt="{{ $post->title }}"
                                        class="w-full h-auto rounded-lg" />
                                @endif

                            </div>
                        @endif
                        <input type="file" name="image" id="image" class="form-control" accept="image/*"
                            onchange="handleImage(event)">
                        @error('image')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <div class="mt-4">
                            <img id="image-preview" class="hidden w-full max-w-xs rounded-lg shadow-md"
                                alt="Pré-visualização da Imagem">
                        </div>
                        <div class="mt-4 text-center">
                            <button type="button" id="crop-button"
                                class="hidden bg-blue-600 text-white px-4 py-2 rounded-lg">Cortar Imagem</button>
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

    <!-- Script para pré-visualização da imagem e edição -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <!-- Cropper.js CSS and JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializa o editor Quill
            var quill = new Quill('#editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{
                            'header': [1, 2, false]
                        }],
                        ['bold', 'italic', 'underline'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        ['link', 'blockquote', 'code-block'],
                        [{
                            'color': []
                        }, {
                            'background': []
                        }],
                        ['clean']
                    ]
                }
            });

            // Carrega o conteúdo existente
            quill.root.innerHTML = `{!! old('content', $post->content) !!}`;

            // Ao enviar o formulário, copia o conteúdo do Quill para o textarea
            document.getElementById('post-form').addEventListener('submit', function() {
                document.getElementById('content').value = quill.root.innerHTML;
            });

            // Inicializa o Cropper.js para cortar a imagem
            let cropper;
            const imagePreview = document.getElementById('image-preview');
            const cropButton = document.getElementById('crop-button');
            const currentImage = document.getElementById('current-image');
            let croppedBlob; // Variável para armazenar o Blob da imagem cortada

            // Função para tratar a pré-visualização e o corte da imagem
            window.handleImage = function(event) {
                const input = event.target;

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                        cropButton.classList.remove('hidden');

                        if (currentImage) {
                            currentImage.classList.add('hidden');
                        }

                        // Destroy any previous cropper instance
                        if (cropper) {
                            cropper.destroy();
                        }

                        // Initialize a new cropper instance
                        cropper = new Cropper(imagePreview, {
                            aspectRatio: 3, // Ajuste para uma proporção mais estreita (ex: 3:1)
                            viewMode: 1,
                            autoCropArea: 1,
                            ready: function() {
                                // Ajusta a área de corte para ser mais estreita
                                const cropBoxData = cropper.getCropBoxData();
                                cropBoxData.width = cropBoxData.width /
                                1.5; // Reduz a largura da área de corte para torná-la mais estreita
                                cropBoxData.height = cropBoxData
                                .height; // Mantém a altura original
                                cropper.setCropBoxData(cropBoxData);
                            },
                        });
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            };

            // Cortar a imagem e substituir a visualização com a versão cortada
            cropButton.addEventListener('click', function() {
                if (cropper) {
                    const canvas = cropper.getCroppedCanvas();

                    // Convert the cropped canvas to a Blob
                    canvas.toBlob(function(blob) {
                        croppedBlob = blob;

                        const croppedUrl = URL.createObjectURL(blob);
                        imagePreview.src = croppedUrl;

                        // Hide the cropper and update the input to contain the cropped image
                        cropper.destroy();
                        cropper = null;
                        cropButton.classList.add('hidden');
                    });
                }
            });

            // Enviar a imagem cortada no formulário
            document.getElementById('post-form').addEventListener('submit', function(e) {
                if (croppedBlob) {
                    // Cria um novo arquivo para o Blob cortado
                    const file = new File([croppedBlob], 'cropped_image.png', {
                        type: 'image/png'
                    });

                    // Cria um objeto FormData e adiciona o arquivo cortado
                    const formData = new FormData(this);
                    formData.append('image', file);

                    // Envia o formulário manualmente com o arquivo cortado
                    e.preventDefault();

                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    }).then(response => {
                        if (response.ok) {
                            window.location.href = response.url;
                        }
                    }).catch(error => console.error('Erro ao enviar a imagem cortada:', error));
                }
            });
        });
    </script>
</x-app-layout>
