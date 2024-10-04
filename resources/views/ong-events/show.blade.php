<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3>{{ __('Data do Evento: ') }} {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}</h3>

                @if ($event->event_time)
                    <p>{{ __('Horário do Evento: ') }} {{ $event->event_time }}</p>
                @endif

                <p>{{ __('Local: ') }} {{ $event->location }}</p>

                <p>{{ __('Cidade: ') }} {{ $event->city }}, {{ $event->state }}</p>

                <p>{{ __('CEP: ') }} {{ $event->cep }}</p>

                <p class="mt-4">{{ $event->description }}</p>

                <hr class="my-4">

                <!-- Informações da ONG -->
                <p><strong>{{ __('Organizador do Evento: ') }}</strong> {{ $event->ong->ong_name }}</p>

                <!-- Verificar se o usuário autenticado é a ONG que cadastrou o evento -->
                @if (Auth::check() && Auth::user()->user_type === 'ong' && Auth::user()->ong->id === $event->ong_id)
                    <div class="flex space-x-4 mt-6">
                        <!-- Botão de Editar -->
                        <a href="{{ route('events.edit', $event->id) }}"
                            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"
                            aria-label="Editar o evento {{ $event->title }}">
                            {{ __('Editar Evento') }}
                        </a>

                        <!-- Botão de Excluir -->
                        <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                            onsubmit="return confirm('{{ __('Tem certeza de que deseja excluir este evento?') }}');">
                            @csrf
                            @method('DELETE')
                            <x-button class="bg-red-500 hover:bg-red-600"
                                aria-label="Excluir o evento {{ $event->title }}">
                                {{ __('Excluir Evento') }}
                            </x-button>
                        </form>
                    </div>
                @endif
                <!-- Share button with icon -->

                <button type="button"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-2 rounded-md flex items-center"
                    id="shareButton">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-7 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                    </svg>
                    {{ __('Compartilhar') }}
                </button>

            </div>



        </div>
    </div>


    <!-- Script to share the event details -->
    <script>
        document.getElementById('shareButton').addEventListener('click', function() {
            const shareData = {
                title: 'Evento: {{ $event->title }}',
                text: 'Participe do evento "{{ $event->title }}" organizado por {{ $event->ong->ong_name }}.',
                url: '{{ route('ong-events.show', $event->id) }}'
            };

            if (navigator.share) {
                navigator.share(shareData)
                    .then(() => console.log('Event shared successfully'))
                    .catch((error) => console.log('Error sharing:', error));
            } else {
                // Fallback if Web Share API is not supported
                navigator.clipboard.writeText(shareData.url)
                    .then(() => alert('Link copiado para a área de transferência!'))
                    .catch(err => console.error('Erro ao copiar link: ', err));
            }
        });
    </script>
</x-app-layout>
