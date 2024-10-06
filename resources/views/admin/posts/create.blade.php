<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Criar Post') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-10">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" id="post-form">
                    @csrf

                    <!-- Campo Título -->
                    <div class="mb-4">
                        <x-label for="title" value="{{ __('Título do Post') }}" />
                        <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Campo Conteúdo (Editor Quill) -->
                    <div class="mb-4">
                        <x-label for="content" value="{{ __('Conteúdo') }}" />
                        <div id="quill-editor" class="block mt-1 w-full" style="height: 200px;"></div>
                        <input type="hidden" id="content" name="content" value="{{ old('content') }}" required>
                        @error('content')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Campo Imagem -->
                    <div class="mb-4">
                        <x-label for="image" value="{{ __('Imagem do Post (opcional)') }}" />
                        <input type="file" id="image" name="image" class="block mt-1 w-full" accept="image/*" onchange="handleImage(event)">
                        @error('image')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <div class="mt-4">
                            <img id="image-preview" class="hidden w-full max-w-xs rounded-lg shadow-md" alt="Pré-visualização da Imagem">
                        </div>
                        <div class="mt-4 text-center">
                            <button type="button" id="crop-button" class="hidden bg-blue-600 text-white px-4 py-2 rounded-lg">Cortar Imagem</button>
                        </div>
                    </div>

                    <!-- Botão de Criar Post -->
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

    <!-- Cropper.js CSS and JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

    <!-- Script para inicializar o Quill e pré-visualização/corte da imagem -->
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

            // Initialize Cropper for image cropping
            let cropper;
            const imagePreview = document.getElementById('image-preview');
            const cropButton = document.getElementById('crop-button');
            let croppedBlob;

            // Preview uploaded image and initialize cropper
            window.handleImage = function (event) {
                const input = event.target;

                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                        cropButton.classList.remove('hidden');

                        // Destroy any previous cropper instance
                        if (cropper) {
                            cropper.destroy();
                        }

                        // Initialize a new cropper instance
                        cropper = new Cropper(imagePreview, {
                            aspectRatio: 3,  // Ajuste para uma proporção mais estreita (ex: 3:1)
                            viewMode: 1,
                            autoCropArea: 1,
                            ready: function () {
                                // Ajusta a área de corte para ser mais estreita
                                const cropBoxData = cropper.getCropBoxData();
                                cropBoxData.width = cropBoxData.width / 1.5;  // Reduz a largura da área de corte para torná-la mais estreita
                                cropBoxData.height = cropBoxData.height; // Mantém a altura original
                                cropper.setCropBoxData(cropBoxData);
                            },
                        });
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            };

            // Crop the image and replace the preview with the cropped version
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

            // Submit the form with the cropped image
            document.getElementById('post-form').addEventListener('submit', function (e) {
                if (croppedBlob) {
                    // Create a new file from the cropped blob
                    const file = new File([croppedBlob], 'cropped_image.png', { type: 'image/png' });

                    // Create a FormData object and append the cropped file
                    const formData = new FormData(this);
                    formData.append('image', file);

                    // Submit the form manually with the cropped file
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
