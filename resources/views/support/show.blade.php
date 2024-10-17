<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Solicitação de Suporte: ') . $supportRequest->subject }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">

                @foreach($messages as $message)
                    <div class="mb-4 border-b pb-4">
                        <strong class="text-blue-600">{{ $message->user->name }}</strong>
                        <p class="text-gray-800">{{ $message->message }}</p>
                        <span class="text-sm text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                    </div>
                @endforeach

                <!-- Message Form (only if the request is still open) -->
                @if($supportRequest->status !== 'closed')
                    <form method="POST" action="{{ route('support.message', $supportRequest) }}" class="space-y-4">
                        @csrf
                        <textarea name="message" rows="4" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="{{ __('Digite sua mensagem aqui...') }}"></textarea>
                        <x-button class="bg-blue-600 hover:bg-blue-700 text-white">{{ __('Enviar Mensagem') }}</x-button>
                    </form>
                @else
                    <p class="text-red-500">{{ __('Esta solicitação de suporte está encerrada.') }}</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
