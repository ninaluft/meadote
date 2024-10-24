<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Eventos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Link de Filtros -->
                <div class="flex justify-end mb-4">
                    <div class="cursor-pointer flex items-center text-indigo-600 hover:text-indigo-800 font-semibold"
                        id="toggleFiltersLink">
                        <span id="toggleFiltersText">Filtros</span>
                        <svg id="toggleFiltersIcon" class="ml-2 w-5 h-5 transition-transform transform rotate-0"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Formulário de Busca - Ocultado inicialmente -->
                <form method="GET" action="{{ route('ong-events.index') }}" id="filtersForm" class="mb-6 hidden"
                    aria-label="Formulário de busca de eventos">
                    <div class="flex flex-wrap gap-2">
                        <!-- Nome do Evento -->
                        <div class="flex flex-col">
                            <x-label for="search_name" value="{{ __('Nome do Evento') }}" />
                            <x-input id="search_name" type="text" name="search_name" value="{{ request('search_name') }}"
                                class="block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm min-w-max w-full px-4 py-2"
                                placeholder="Buscar por nome do evento" />
                        </div>

                        <!-- Cidade -->
                        <div class="flex flex-col">
                            <x-label for="search_city" value="{{ __('Cidade') }}" />
                            <x-input id="search_city" type="text" name="search_city" value="{{ request('search_city') }}"
                                class="block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm min-w-max w-full px-4 py-2"
                                placeholder="Buscar por cidade" />
                        </div>

                        <!-- Organizador -->
                        <div class="flex flex-col">
                            <x-label for="search_organizer" value="{{ __('Organizador') }}" />
                            <x-input id="search_organizer" type="text" name="search_organizer"
                                value="{{ request('search_organizer') }}"
                                class="block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm min-w-max w-full px-4 py-2"
                                placeholder="Buscar por organizador" />
                        </div>

                        <!-- Botão de busca -->
                        <div class="flex items-end">
                            <x-button class="flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">
                                <i class="fas fa-search text-white m-1"></i>
                            </x-button>
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

    <script>
        // Script para alternar a visibilidade da barra de filtros
        const toggleFiltersLink = document.getElementById('toggleFiltersLink');
        const filtersForm = document.getElementById('filtersForm');
        const toggleFiltersText = document.getElementById('toggleFiltersText');
        const toggleFiltersIcon = document.getElementById('toggleFiltersIcon');

        toggleFiltersLink.addEventListener('click', () => {
            filtersForm.classList.toggle('hidden');

            if (filtersForm.classList.contains('hidden')) {
                toggleFiltersText.textContent = 'Mostrar Filtros';
                toggleFiltersIcon.classList.remove('rotate-180');
            } else {
                toggleFiltersText.textContent = 'Esconder Filtros';
                toggleFiltersIcon.classList.add('rotate-180');
            }
        });
    </script>
</x-app-layout>
