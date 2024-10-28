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
                    <div class="cursor-pointer flex items-center text-teal-600 hover:text-teal-700 font-semibold"
                        id="toggleFiltersLink">
                        <span id="toggleFiltersText">Filtros</span>
                        <svg id="toggleFiltersIcon" class="ml-2 w-5 h-5 transition-transform transform rotate-0"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Formulário de Busca - Ocultado inicialmente -->
                <form method="GET" action="{{ route('ong-events.index') }}" id="filtersForm"
                    class="mb-6 hidden bg-gray-50 p-6 rounded-lg shadow-md w-full"
                    aria-label="Formulário de busca de eventos">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 items-end">

                        <!-- Nome do Evento -->
                        <div class="flex flex-col flex-grow">
                            <x-label for="search_name" value="{{ __('Nome do Evento') }}" />
                            <div class="relative">
                                <i class="fas fa-calendar-alt absolute left-3 top-3 text-gray-400"></i>
                                <x-input id="search_name" type="text" name="search_name"
                                    value="{{ request('search_name') }}"
                                    class="pl-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                    placeholder="Buscar por nome do evento" />
                            </div>
                        </div>

                        <!-- Cidade -->
                        <div class="flex flex-col flex-grow">
                            <x-label for="search_city" value="{{ __('Cidade') }}" />
                            <div class="relative">
                                <i class="fas fa-map-marker-alt absolute left-3 top-3 text-gray-400"></i>
                                <x-input id="search_city" type="text" name="search_city"
                                    value="{{ request('search_city') }}"
                                    class="pl-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                    placeholder="Buscar por cidade" />
                            </div>
                        </div>

                        <!-- Organizador -->
                        <div class="flex flex-col flex-grow">
                            <x-label for="search_organizer" value="{{ __('Organizador') }}" />
                            <div class="relative">
                                <i class="fas fa-user-tie absolute left-3 top-3 text-gray-400"></i>
                                <x-input id="search_organizer" type="text" name="search_organizer"
                                    value="{{ request('search_organizer') }}"
                                    class="pl-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                    placeholder="Buscar por organizador" />
                            </div>
                        </div>

                        <!-- Botão de busca -->
                        <div class="flex items-end">
                            <button type="submit"
                                class="px-4 py-2 bg-teal-600 text-white font-semibold rounded-md hover:bg-teal-700 transition shadow-lg"
                                style="width: 100px;">
                                Buscar
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Display Active Filters Summary with Clear Filters Button -->
                @php
                    $activeFilters = [];
                    if (request('search_name')) {
                        $activeFilters[] = 'Nome do Evento: ' . request('search_name');
                    }
                    if (request('search_city')) {
                        $activeFilters[] = 'Cidade: ' . request('search_city');
                    }
                    if (request('search_organizer')) {
                        $activeFilters[] = 'Organizador: ' . request('search_organizer');
                    }
                @endphp

                @if (count($activeFilters) > 0)
                    <div
                        class="mb-6 p-2 bg-teal-50 text-teal-800 rounded-md border border-teal-200 flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div class="mb-2 md:mb-0">
                            <p class="font-semibold">Filtros ativos:</p>
                            <ul class="list-disc list-inside">
                                @foreach ($activeFilters as $filter)
                                    <li>{{ $filter }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- Clear Filters Button -->
                        <a href="{{ route('ong-events.index') }}"
                            class="mt-2 md:mt-0 px-4 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-600 transition shadow-sm">
                            Limpar Filtros
                        </a>
                    </div>
                @endif

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
