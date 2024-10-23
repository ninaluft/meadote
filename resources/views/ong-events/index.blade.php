<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Eventos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Formulário de Busca -->
                <form method="GET" action="{{ route('ong-events.index') }}" class="mb-6"
                    aria-label="Formulário de busca de eventos">
                    <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0">
                        <div class="w-full md:w-1/4">
                            <x-label for="search_name" value="{{ __('Nome do Evento') }}" />
                            <x-input id="search_name" type="text" name="search_name"
                                value="{{ request('search_name') }}" class="mt-1 block w-full"
                                placeholder="Buscar por nome do evento" />
                        </div>

                        <div class="w-full md:w-1/4">
                            <x-label for="search_city" value="{{ __('Cidade') }}" />
                            <x-input id="search_city" type="text" name="search_city"
                                value="{{ request('search_city') }}" class="mt-1 block w-full"
                                placeholder="Buscar por cidade" />
                        </div>

                        <div class="w-full md:w-1/4">
                            <x-label for="search_organizer" value="{{ __('Organizador') }}" />
                            <x-input id="search_organizer" type="text" name="search_organizer"
                                value="{{ request('search_organizer') }}" class="mt-1 block w-full"
                                placeholder="Buscar por organizador" />
                        </div>

                        <!-- Botão de busca -->
                        <div class="flex items-end">
                            <x-button class="w-full sm:w-auto h-10">{{ __('Buscar') }}</x-button>
                        </div>
                    </div>
                </form>


                <!-- Lista de Eventos Futuros -->
                <h3 class="text-lg font-semibold mb-4">{{ __('Eventos Futuros') }}</h3>

                @if ($futureEvents->isEmpty())
                    <p class="text-gray-600 text-center">{{ __('Nenhum evento futuro encontrado.') }}</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                        @foreach ($futureEvents as $event)
                            <a href="{{ route('ong-events.show', $event->id) }}"
                                class="block bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <!-- Imagem do Evento -->
                                @if ($event->photo_path)
                                    <x-image :src="$event->photo_path" alt="{{ $event->title }}"
                                        class="w-full h-48 object-cover" />
                                @else
                                    <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                                        <span class="text-gray-700 font-bold">{{ __('Imagem Indisponível') }}</span>
                                    </div>
                                @endif

                                <!-- Detalhes do Evento -->
                                <div class="p-4">
                                    <h4 class="text-xl font-semibold text-gray-800">{{ $event->title }}</h4>
                                    <p class="text-gray-600">
                                        <strong>{{ __('Data:') }}</strong>
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}
                                    </p>
                                    <p class="text-gray-600">
                                        <strong>{{ __('Cidade:') }}</strong> {{ $event->city }}
                                    </p>
                                    <p class="text-gray-600">
                                        <strong>{{ __('Organizador:') }}</strong> {{ $event->ong->ong_name }}
                                    </p>
                                    <p class="mt-2 text-indigo-600 hover:underline font-medium">
                                        {{ __('Ver Evento') }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Links de Paginação dos Eventos Futuros -->
                    <div class="mt-6">
                        {{ $futureEvents->links('pagination::bootstrap-4') }}
                    </div>
                @endif

                <!-- Linha de Separação -->
                <hr class="my-12 border-t-2 border-gray-300">

                <!-- Lista de Eventos Passados -->
                <h3 class="text-lg font-semibold mt-10 mb-4">{{ __('Eventos Passados') }}</h3>

                @if ($pastEvents->isEmpty())
                    <p class="text-gray-600 text-center">{{ __('Nenhum evento passado encontrado.') }}</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($pastEvents as $event)
                            <a href="{{ route('ong-events.show', $event->id) }}"
                                class="block bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <!-- Imagem do Evento -->
                                @if ($event->photo_path)
                                    <x-image :src="$event->photo_path" alt="{{ $event->title }}"
                                        class="w-full h-48 object-cover" />
                                @else
                                    <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                                        <span class="text-gray-700 font-bold">{{ __('Imagem Indisponível') }}</span>
                                    </div>
                                @endif

                                <!-- Detalhes do Evento -->
                                <div class="p-4">
                                    <h4 class="text-xl font-semibold text-gray-800">{{ $event->title }}</h4>
                                    <p class="text-gray-600">
                                        <strong>{{ __('Data:') }}</strong>
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}
                                    </p>
                                    <p class="text-gray-600">
                                        <strong>{{ __('Cidade:') }}</strong> {{ $event->city }}
                                    </p>
                                    <p class="mt-2 text-indigo-600 hover:underline font-medium">
                                        {{ __('Ver Evento') }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Links de Paginação dos Eventos Passados -->
                    <div class="mt-6">
                        {{ $pastEvents->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
