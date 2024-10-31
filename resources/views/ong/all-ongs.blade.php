<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ONGs cadastradas em nosso sistema') }}
        </h2>
    </x-slot>

    <div class="py-8">
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

                <!-- Formulário de busca - Ocultado inicialmente -->
                <form action="{{ route('ongs.index') }}" method="GET" id="filtersForm"
                    class="mb-6 hidden bg-gray-50 p-6 rounded-lg shadow-md w-full">
                    <div class="flex flex-wrap gap-4 items-end">

                        <!-- Nome da ONG -->
                        <div class="flex-grow">
                            <x-label for="ong_name" value="Nome da ONG" />
                            <div class="relative">
                                <i class="fas fa-building absolute left-3 top-3 text-gray-400"></i>
                                <x-input id="ong_name" name="ong_name" value="{{ request('ong_name') }}"
                                    placeholder="Nome da ONG"
                                    class="pl-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" />
                            </div>
                        </div>

                        <!-- Cidade -->
                        <div class="flex-grow">
                            <x-label for="city" value="Cidade" />
                            <div class="relative">
                                <i class="fas fa-map-marker-alt absolute left-3 top-3 text-gray-400"></i>
                                <x-input id="city" name="city" value="{{ request('city') }}" placeholder="Cidade"
                                    class="pl-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" />
                            </div>
                        </div>

                        <!-- Botão de buscar -->
                        <div class="flex-shrink-0">
                            <x-button type="submit"
                                class="px-6 py-2 bg-teal-600 text-white font-semibold rounded-md hover:bg-teal-700 transition shadow-lg">
                                Buscar
                            </x-button>
                        </div>
                    </div>
                </form>

                <!-- Active Filters Summary with Clear Filters Button -->
                @php
                    $activeFilters = [];
                    if (request('ong_name')) $activeFilters[] = 'Nome da ONG: ' . request('ong_name');
                    if (request('city')) $activeFilters[] = 'Cidade: ' . request('city');
                @endphp

                @if (count($activeFilters) > 0)
                    <div class="mb-6 p-4 bg-teal-50 text-teal-800 rounded-md border border-teal-200 flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div class="mb-2 md:mb-0">
                            <p class="font-semibold">Filtros ativos:</p>
                            <ul class="list-disc list-inside">
                                @foreach ($activeFilters as $filter)
                                    <li>{{ $filter }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- Clear Filters Button -->
                        <a href="{{ route('ongs.index') }}"
                            class="mt-2 md:mt-0 px-4 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-600 transition shadow-sm">
                            Limpar Filtros
                        </a>
                    </div>
                @endif

                <!-- Lista de ONGs -->
                @if ($ongs->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($ongs as $ong)
                        <a href="{{ route('user.public-profile', $ong->user->id) }}" class="block bg-white shadow-md rounded-lg overflow-hidden p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="h-32 w-32 bg-gray-200 flex items-center justify-center rounded-full overflow-hidden">
                                        @if (!empty($ong->user->profile_photo))
                                            <!-- Displaying profile photo -->
                                            <x-image :src="$ong->user->profile_photo" alt="{{ $ong->ong_name }}"
                                                class="h-32 w-32 object-cover rounded-full" />
                                        @else
                                            <!-- Displaying initials -->
                                            <x-initials-avatar :user="$ong->user" class="h-32 w-32 text-4xl" />
                                        @endif
                                    </div>
                                </div>

                                <div class="ml-6 flex flex-col justify-center">
                                    <h2 class="text-lg font-bold mb-2 text-blue-600 hover:underline">
                                        {{ $ong->ong_name }}
                                    </h2>
                                    <p class="text-gray-600">
                                        {{ $ong->user->city }}, {{ $ong->user->state }}
                                    </p>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-6">
                        {{ $ongs->links() }}
                    </div>
                @else
                    <p class="text-center text-gray-600">{{ __('Nenhuma ONG encontrada.') }}</p>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Script to toggle the visibility of the filter form
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
