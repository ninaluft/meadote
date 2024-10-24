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
                    <div class="cursor-pointer flex items-center text-indigo-600 hover:text-indigo-800 font-semibold"
                        id="toggleFiltersLink">
                        <span id="toggleFiltersText">Filtros</span>
                        <svg id="toggleFiltersIcon" class="ml-2 w-5 h-5 transition-transform transform rotate-0"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>

                <!-- Barra de Busca - Ocultada inicialmente -->
                <form action="{{ route('pets.all-pets') }}" method="GET" id="filtersForm" class="mb-6 hidden">
                    <div class="flex flex-wrap gap-2">

                        <!-- Cidade -->
                        <div class="flex flex-col">
                            <x-label for="city" value="Cidade" />
                            <x-input id="city"
                                class="block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm min-w-max"
                                type="text" name="city" value="{{ request('city') }}"
                                placeholder="Digite a cidade" />
                        </div>

                        <!-- Espécie -->
                        <div class="flex flex-col">
                            <x-label for="species" value="Espécie" />
                            <select id="species" name="species"
                                class="block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm min-w-max">
                                <option value="">Todas</option>
                                <option value="dog" {{ request('species') == 'dog' ? 'selected' : '' }}>Cachorro
                                </option>
                                <option value="cat" {{ request('species') == 'cat' ? 'selected' : '' }}>Gato</option>
                                <option value="other" {{ request('species') == 'other' ? 'selected' : '' }}>Outro
                                </option>
                            </select>
                        </div>

                        <!-- Sexo -->
                        <div class="flex flex-col">
                            <x-label for="gender" value="Sexo" />
                            <select id="gender" name="gender"
                                class="block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm min-w-max">
                                <option value="">Todos</option>
                                <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Macho
                                </option>
                                <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Fêmea
                                </option>
                            </select>
                        </div>

                        <!-- Castrado -->
                        <div class="flex flex-col">
                            <x-label for="is_neutered" value="Castrado" />
                            <select id="is_neutered" name="is_neutered"
                                class="block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm min-w-max">
                                <option value="">Todos</option>
                                <option value="1" {{ request('is_neutered') == '1' ? 'selected' : '' }}>Sim
                                </option>
                                <option value="0" {{ request('is_neutered') == '0' ? 'selected' : '' }}>Não
                                </option>
                            </select>
                        </div>


                        <!-- Porte -->
                        <div class="flex flex-col">
                            <x-label for="size" value="Porte" />
                            <select id="size" name="size"
                                class="block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm min-w-max">
                                <option value="">Todos</option>
                                <option value="small" {{ request('size') == 'small' ? 'selected' : '' }}>Pequeno
                                </option>
                                <option value="medium" {{ request('size') == 'medium' ? 'selected' : '' }}>Médio
                                </option>
                                <option value="large" {{ request('size') == 'large' ? 'selected' : '' }}>Grande
                                </option>
                            </select>
                        </div>



                        <!-- Idade Aproximada -->
                        <div class="flex flex-col">
                            <x-label for="age" value="Idade Aproximada" />
                            <select id="age" name="age"
                                class="block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm min-w-max">
                                <option value="">Todas</option>
                                <option value="puppy" {{ request('age') == 'puppy' ? 'selected' : '' }}>Filhote
                                </option>
                                <option value="adult" {{ request('age') == 'adult' ? 'selected' : '' }}>Adulto
                                </option>
                                <option value="senior" {{ request('age') == 'senior' ? 'selected' : '' }}>Sênior
                                </option>
                            </select>
                        </div>



                        <!-- Botão de busca -->
                        <div class="flex items-end">
                            <x-button
                                class="flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">
                                <i class="fas fa-search text-white m-1 "></i>
                                {{-- <span class="ml-2">{{ __('') }}</span> --}}
                            </x-button>
                        </div>
                    </div>
                </form>



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
                toggleFiltersText.textContent = 'Mostrar Filtros';
                toggleFiltersIcon.classList.remove('rotate-180');
            } else {
                toggleFiltersText.textContent = 'Esconder Filtros';
                toggleFiltersIcon.classList.add('rotate-180');
            }
        });
    </script>
</x-app-layout>
