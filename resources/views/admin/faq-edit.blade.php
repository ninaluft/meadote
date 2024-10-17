<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Editar FAQs
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white shadow-md rounded-lg p-6">

                <!-- Formulário para editar e salvar o conteúdo das FAQs -->
                <form action="{{ route('faqs.store') }}" method="POST">
                    @csrf

                    <!-- Editor de FAQs (Summernote) -->
                    <div class="mb-4">
                        <label for="faqEditor" class="form-label">Conteúdo das FAQs</label>
                        <textarea id="faqEditor" name="faq_content">{{ $faqContent }}</textarea>
                    </div>

                    <!-- Botão de Salvar -->
                    <button type="submit" class="btn btn-primary mt-3">Salvar FAQs</button>
                </form>

            </div>
        </div>
    </div>

    <!-- Include Summernote CSS/JS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <!-- Inicializar o Editor Summernote -->
    <script>
        $(document).ready(function() {
            $('#faqEditor').summernote({
                height: 600, // Altura do editor
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['view', ['codeview']] // Habilita a visualização do código HTML
                ]
            });
        });
    </script>
</x-app-layout>
