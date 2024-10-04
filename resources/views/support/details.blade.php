<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes da Solicitação de Suporte') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">{{ $supportRequest->subject }}</h3>

                <p>Status: {{ $supportRequest->status }}</p>

                <!-- Display messages related to the support request -->
                <div class="mt-4">
                    @foreach ($messages as $message)
                        <div class="mb-3 p-4 bg-gray-100 rounded-md">
                            <strong>{{ $message->user->name }}</strong> disse:
                            <p>{{ $message->message }}</p>
                            <span class="text-sm text-gray-600">{{ $message->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
