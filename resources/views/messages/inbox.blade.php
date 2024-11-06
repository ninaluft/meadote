<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mensagens') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6">
                @if($conversations->isEmpty())
                    <p>{{ __('Você ainda não tem conversas.') }}</p>
                @else
                    <!-- Container para a lista de conversas, onde será carregada a view parcial -->
                    <div id="inbox-conversations" class="overflow-y-auto h-[450px]">
                        @include('messages.partials.inbox-conversations', ['conversations' => $conversations])
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
