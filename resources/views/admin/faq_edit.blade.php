<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Perguntas Frequentes (FAQs)') }}
        </h2>

    </x-slot>

    <!-- Na view de edição -->
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">


                <form action="{{ route('faqs.update') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <x-label for="content" value="{{ __('Conteúdo das FAQs') }}" />
                        <div id="quill-editor" class="block mt-1 w-full" style="height: 300px;"></div>
                        <input type="hidden" id="content" name="content"
                            value="{{ $faq ? $faq->content : old('content') }}" required>
                        @error('content')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <x-button>
                        {{ __('Salvar FAQs') }}
                    </x-button>
                </form>
            </div>
        </div>
    </div>

    <!-- Quill Editor CSS and JS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <!-- Script para inicializar o Quill Editor -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializa o Quill Editor
            var quill = new Quill('#quill-editor', {
                theme: 'snow',
                placeholder: 'Digite o conteúdo das FAQs aqui...',
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
                        [{
                            'color': []
                        }, {
                            'background': []
                        }],
                        ['link', 'code-block']
                    ]
                }
            });

            // Define o conteúdo inicial no editor
            var initialContent = `{!! $faq ? addslashes($faq->content) : old('content') !!}`;
            quill.clipboard.dangerouslyPasteHTML(initialContent);

            // Atualiza o campo oculto sempre que o conteúdo do editor mudar
            quill.on('text-change', function() {
                document.getElementById('content').value = quill.root.innerHTML;
            });
        });
    </script>
</x-app-layout>
