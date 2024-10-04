{{-- resources/views/support/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nova Solicitação de Suporte') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('support.store') }}">
                    @csrf

                    <!-- Assunto -->
                    <div>
                        <x-label for="subject" value="{{ __('Assunto') }}" />
                        <x-input id="subject" class="block mt-1 w-full" type="text" name="subject" value="{{ old('subject') }}" required autofocus />
                        @error('subject')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Mensagem -->
                    <div class="mt-4">
                        <x-label for="message" value="{{ __('Mensagem') }}" />
                        <textarea id="message" name="message" rows="5" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>{{ old('message') }}</textarea>
                        @error('message')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Botão de Enviar -->
                    <div class="mt-4">
                        <x-button>
                            {{ __('Enviar Solicitação') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
