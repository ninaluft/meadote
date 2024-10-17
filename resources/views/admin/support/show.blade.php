<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Solicitação de Suporte: ') . $supportRequest->subject }}
        </h2>
    </x-slot>

    <section class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">

                @foreach($messages as $message)
                    <div class="mb-4">
                        <strong class="text-blue-600">{{ $message->user->name }}</strong>:
                        <p class="text-gray-800">{{ $message->message }}</p>
                        <span class="text-sm text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                    </div>
                @endforeach

                <!-- Formulário de Mensagem (somente se a solicitação ainda estiver aberta) -->
                @if($supportRequest->status !== 'closed')
                    <form method="POST" action="{{ route('support.message', $supportRequest) }}" class="space-y-4">
                        @csrf
                        <textarea name="message" rows="4" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="{{ __('Digite sua mensagem aqui...') }}"></textarea>
                        <div class="flex space-x-4">
                            <x-button class="bg-blue-600 hover:bg-blue-700 text-white">{{ __('Enviar Mensagem') }}</x-button>
                        </div>
                    </form>
                @else
                    <p class="text-red-500">{{ __('Esta solicitação de suporte está encerrada.') }}</p>
                @endif

                <!-- Botão do Administrador para Encerrar Solicitação -->
                @if($supportRequest->status !== 'closed')
                    <form method="POST" action="{{ route('admin.support.close', $supportRequest) }}" class="mt-4" onsubmit="return confirm('{{ __('Tem certeza que deseja encerrar esta solicitação?') }}');">
                        @csrf
                        <x-button class="bg-red-500 hover:bg-red-600 text-white">{{ __('Encerrar Solicitação') }}</x-button>
                    </form>
                @endif
            </div>
        </div>
    </section>
</x-app-layout>
