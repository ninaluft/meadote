<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Eventos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Formulário de Busca -->
                <form method="GET" action="{{ route('ong-events.index') }}" class="mb-6"
                    aria-label="Formulário de busca de eventos">
                    <div class="flex space-x-4">
                        <div>
                            <x-label for="search_name" value="{{ __('Nome do Evento') }}" />
                            <x-input id="search_name" type="text" name="search_name"
                                value="{{ request('search_name') }}" class="mt-1 block w-full"
                                placeholder="Buscar por nome do evento" />
                        </div>

                        <div>
                            <x-label for="search_city" value="{{ __('Cidade') }}" />
                            <x-input id="search_city" type="text" name="search_city"
                                value="{{ request('search_city') }}" class="mt-1 block w-full"
                                placeholder="Buscar por cidade" />
                        </div>

                        <div class="self-end">
                            <x-button type="submit" class="ml-4">
                                {{ __('Buscar') }}
                            </x-button>
                        </div>
                    </div>
                </form>

                <!-- Lista de Eventos -->
                <h3 class="text-lg font-semibold">{{ __('Lista de Eventos') }}</h3>

                @if ($events->isEmpty())
                    <p>Nenhum evento encontrado.</p>
                @else
                    <ul class="mt-4">
                        @foreach ($events as $event)
                            <li class="mb-4">
                                <h4>{{ $event->title }}</h4>
                                <p><strong>Data:</strong>
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}
                                    <strong>Cidade:</strong> {{ $event->city }}</p>
                                <a href="{{ route('ong-events.show', $event->id) }}"
                                    class="text-indigo-600 hover:underline">Ver Evento</a>
                            </li>
                            <hr class="my-4">
                        @endforeach
                    </ul>
                @endif
            </div>
            <!-- Links de Paginação -->
            <div class="mt-6">
                {{ $events->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
