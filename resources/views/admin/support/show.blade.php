<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Solicitação de Suporte: ') . $supportRequest->subject }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @foreach($messages as $message)
                    <div class="mb-4">
                        <strong>{{ $message->user->name }}</strong>: {{ $message->message }}
                        <span class="text-sm text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                    </div>
                @endforeach

                <!-- Formulário de Mensagem (somente se a solicitação ainda estiver aberta) -->
                @if($supportRequest->status !== 'closed')
                    <form method="POST" action="{{ route('support.message', $supportRequest) }}">
                        @csrf
                        <textarea name="message" rows="4" class="w-full"></textarea>
                        <x-button>{{ __('Enviar Mensagem') }}</x-button>
                    </form>
                @else
                    <p class="text-red-500">Esta solicitação de suporte está encerrada.</p>
                @endif

                <!-- Botão do Administrador para Encerrar Solicitação -->
                @if($supportRequest->status !== 'closed')
                    <form method="POST" action="{{ route('admin.support.close', $supportRequest) }}">
                        @csrf
                        <x-button class="bg-red-500">{{ __('Encerrar Solicitação') }}</x-button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
