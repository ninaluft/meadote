<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Todos os Pets Disponíveis') }}
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

                <!-- Barra de Busca - Ocultada inicialmente -->
                <form action="{{ route('pets.all-pets') }}" method="GET" id="filtersForm"
                    class="mb-6 hidden bg-gray-50 p-6 rounded-lg shadow-md">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

                        <!-- Cidade -->
                        <div class="flex flex-col">
                            <x-label for="city" value="Cidade" />
                            <div class="relative">
                                <i class="fas fa-map-marker-alt absolute left-3 top-3 text-gray-400"></i>
                                <x-input id="city"
                                    class="pl-10 border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-md shadow-sm w-full"
                                    type="text" name="city" value="{{ request('city') }}"
                                    placeholder="Digite a cidade" />
                            </div>
                        </div>

                        <!-- Espécie -->
                        <div class="flex flex-col">
                            <x-label for="species" value="Espécie" />
                            <div class="relative">
                                <i class="fas fa-paw absolute left-3 top-3 text-gray-400"></i>
                                <select id="species" name="species"
                                    class="pl-10 border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-md shadow-sm w-full">
                                    <option value="">Todas</option>
                                    <option value="dog" {{ request('species') == 'dog' ? 'selected' : '' }}>Cachorro
                                    </option>
                                    <option value="cat" {{ request('species') == 'cat' ? 'selected' : '' }}>Gato
                                    </option>
                                    <option value="other" {{ request('species') == 'other' ? 'selected' : '' }}>Outro
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Sexo -->
                        <div class="flex flex-col">
                            <x-label for="gender" value="Sexo" />
                            <div class="relative">
                                <i class="fas fa-venus-mars absolute left-3 top-3 text-gray-400"></i>
                                <select id="gender" name="gender"
                                    class="pl-10 border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-md shadow-sm w-full">
                                    <option value="">Todos</option>
                                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Macho
                                    </option>
                                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Fêmea
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Castrado -->
                        <div class="flex flex-col">
                            <x-label for="is_neutered" value="Castrado" />
                            <div class="relative">
                                <i class="fas fa-cut absolute left-3 top-3 text-gray-400"></i>
                                <select id="is_neutered" name="is_neutered"
                                    class="pl-10 border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-md shadow-sm w-full">
                                    <option value="">Todos</option>
                                    <option value="1" {{ request('is_neutered') == '1' ? 'selected' : '' }}>Sim
                                    </option>
                                    <option value="0" {{ request('is_neutered') == '0' ? 'selected' : '' }}>Não
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Porte -->
                        <div class="flex flex-col">
                            <x-label for="size" value="Porte" />
                            <div class="relative">
                                <i class="fas fa-dog absolute left-3 top-3 text-gray-400"></i>
                                <select id="size" name="size"
                                    class="pl-10 border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-md shadow-sm w-full">
                                    <option value="">Todos</option>
                                    <option value="small" {{ request('size') == 'small' ? 'selected' : '' }}>Pequeno
                                    </option>
                                    <option value="medium" {{ request('size') == 'medium' ? 'selected' : '' }}>Médio
                                    </option>
                                    <option value="large" {{ request('size') == 'large' ? 'selected' : '' }}>Grande
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Idade Aproximada -->
                        <div class="flex flex-col">
                            <x-label for="age" value="Idade Aproximada" />
                            <div class="relative">
                                <i class="fas fa-birthday-cake absolute left-3 top-3 text-gray-400"></i>
                                <select id="age" name="age"
                                    class="pl-10 border-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-md shadow-sm w-full">
                                    <option value="">Todas</option>
                                    <option value="puppy" {{ request('age') == 'puppy' ? 'selected' : '' }}>Filhote
                                    </option>
                                    <option value="adult" {{ request('age') == 'adult' ? 'selected' : '' }}>Adulto
                                    </option>
                                    <option value="senior" {{ request('age') == 'senior' ? 'selected' : '' }}>Sênior
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Botão de busca -->
                        <div class="flex items-end">
                            <x-button type="submit"
                                class="flex items-center px-4 py-2 bg-teal-600 text-white font-semibold rounded-md hover:bg-teal-700 transition shadow-lg">
                                <i class="fas fa-search text-white mr-2"></i>Buscar
                            </x-button>
                        </div>
                    </div>
                </form>


                <!-- Display Active Filters Summary with Clear Filters Button -->
                @php
                    $activeFilters = [];
                    if (request('city')) {
                        $activeFilters[] = 'Cidade: ' . request('city');
                    }
                    if (request('species')) {
                        $activeFilters[] =
                            'Espécie: ' .
                            (request('species') == 'dog'
                                ? 'Cachorro'
                                : (request('species') == 'cat'
                                    ? 'Gato'
                                    : 'Outro'));
                    }
                    if (request('gender')) {
                        $activeFilters[] = 'Sexo: ' . (request('gender') == 'male' ? 'Macho' : 'Fêmea');
                    }
                    if (request('is_neutered') !== null) {
                        $activeFilters[] = 'Castrado: ' . (request('is_neutered') == '1' ? 'Sim' : 'Não');
                    }
                    if (request('size')) {
                        $activeFilters[] =
                            'Porte: ' .
                            (request('size') == 'small'
                                ? 'Pequeno'
                                : (request('size') == 'medium'
                                    ? 'Médio'
                                    : 'Grande'));
                    }
                    if (request('age')) {
                        $activeFilters[] =
                            'Idade: ' .
                            (request('age') == 'puppy' ? 'Filhote' : (request('age') == 'adult' ? 'Adulto' : 'Sênior'));
                    }
                @endphp

                @if (count($activeFilters) > 0)
                    <div
                        class="mb-6 p-1 bg-teal-50 text-teal-800 rounded-md border border-teal-200 flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div class="mb-2 md:mb-0">
                            <p class="font-semibold">Filtros ativos:</p>
                            <ul class="list-disc list-inside">
                                @foreach ($activeFilters as $filter)
                                    <li>{{ $filter }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <a href="{{ route('pets.all-pets') }}"
                            class="mt-2 md:mt-0 px-4 py-2 bg-red-500 text-white font-semibold rounded-md hover:bg-red-600 transition shadow-sm">
                            Limpar Filtros
                        </a>
                    </div>
                @endif

                <!-- Exibição dos Pets -->
                @if ($pets->isEmpty())
                    <p>Nenhum pet está disponível para adoção no momento.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($pets as $pet)
                            <a href="{{ route('pets.show', $pet->id) }}"
                                class="block hover:shadow-lg transition-shadow duration-300">
                                <x-pet-card :pet="$pet" />
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="mt-6">
                {{ $pets->links() }}
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
                toggleFiltersText.textContent = 'Filtros';
                toggleFiltersIcon.classList.remove('rotate-180');
            } else {
                toggleFiltersText.textContent = 'Esconder Filtros';
                toggleFiltersIcon.classList.add('rotate-180');
            }
        });
    </script>
</x-app-layout>
