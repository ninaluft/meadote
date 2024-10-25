<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Editar Rodapé') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white shadow-md rounded-lg p-6">

                <!-- Mensagem de Sucesso -->
                @if (session('success'))
                    <div class="bg-green-500 text-white font-bold p-4 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Formulário para editar o rodapé -->
                <form action="{{ route('admin.footer.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Campo para editar o conteúdo do rodapé -->
                    <div class="mb-4">
                        <label for="content" class="form-label">Conteúdo do Rodapé</label>
                        <textarea id="summernote" name="content" class="form-input mt-1 block w-full border border-gray-300 rounded-md p-2">{{ old('content', $footerContent ?? '') }}</textarea>
                    </div>

                    <!-- Botão para salvar -->
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition duration-200 ease-in-out">
                        {{ __('Salvar Rodapé') }}
                    </button>
                </form>

            </div>
        </div>
    </div>

    <!-- Summernote CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>

    <!-- Inicializar Summernote com opções de cor -->
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300,   // Altura do editor
                tabsize: 2,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['color', ['color']], // Ferramenta para escolher cor do texto
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['codeview']],  // Habilita visualização de código HTML
                ]
            });
        });
    </script>
</x-app-layout>
