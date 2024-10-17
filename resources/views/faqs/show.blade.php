<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Perguntas Frequentes (FAQs)
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white shadow-md rounded-lg p-6">
                <!-- Renderiza o conteúdo das FAQs -->
                {!! $faqContent !!}
            </div>
        </div>
    </div>
</x-app-layout>
