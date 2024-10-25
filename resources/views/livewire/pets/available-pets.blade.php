<div>
    {{-- Lista de Pets Disponíveis --}}
    <div class="bg-gray-200 p-2 rounded flex justify-between items-center">
        <h3 class="text-xl font-semibold">Pets Disponíveis para Adoção ({{ $availablePets->total() }})</h3>
        <a href="{{ route('pets.create') }}"
            class="bg-green-500 text-white font-bold px-2 py-2 rounded hover:bg-green-600 transition duration-300 flex items-center justify-center text-center sm:whitespace-nowrap break-words">
            + Adicionar Pet
        </a>
    </div>

    <!-- Link de Filtros -->
    <div class="flex justify-end mb-4">
        <div class="cursor-pointer flex items-center text-teal-600 hover:text-teal-700 font-semibold"
            id="toggleFiltersLink1">
            <span id="toggleFiltersText1">Filtros</span>
            <svg id="toggleFiltersIcon1" class="ml-2 w-5 h-5 transition-transform transform rotate-0"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>


    {{-- Formulário de Filtro - Ocultado inicialmente --}}
    <div id="filtersForm1" class="bg-gray-100 p-4 rounded mb-6 hidden">
        <div class="flex flex-wrap gap-4 items-end">
            <!-- Nome -->
            <div class="flex flex-col">
                <x-label for="searchName" value="Nome" />
                <input type="text" wire:model="searchName" placeholder="Buscar por nome"
                    class="block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-4 py-2 min-w-max" />
            </div>

            <!-- Gênero -->
            <div class="flex flex-col">
                <x-label for="searchGender" value="Gênero" />
                <select wire:model="searchGender"
                    class="block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-4 py-2 min-w-max">
                    <option value="">Todos</option>
                    <option value="male">Macho</option>
                    <option value="female">Fêmea</option>
                </select>
            </div>

            <!-- Espécie -->
            <div class="flex flex-col">
                <x-label for="searchSpecies" value="Espécie" />
                <select wire:model="searchSpecies"
                    class="block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-4 py-2 min-w-max">
                    <option value="">Todas</option>
                    <option value="dog">Cachorro</option>
                    <option value="cat">Gato</option>
                    <option value="other">Outro</option>
                </select>
            </div>

            <!-- Botão de buscar -->
            <div class="flex items-end">
                <x-button wire:click="applyFilters"
                    class="flex items-center justify-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">
                    <i class="fas fa-search text-white m-1"></i>

                </x-button>
            </div>
        </div>
    </div>


    @if ($availablePets->isEmpty())
        <p class="text-gray-600">Nenhum pet disponível para adoção corresponde aos critérios de busca.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @foreach ($availablePets as $pet)
                <a href="{{ route('pets.show', $pet->id) }}"
                    class="block hover:shadow-lg transition-shadow duration-300">
                    <x-pet-card :pet="$pet" />
                </a>
            @endforeach
        </div>
        <div class="mt-6">
            {{ $availablePets->links() }}
        </div>
    @endif
</div>

<script>
    // Script para alternar a visibilidade da barra de filtros
    const toggleFiltersLink1 = document.getElementById('toggleFiltersLink1');
    const filtersForm1 = document.getElementById('filtersForm1');
    const toggleFiltersText1 = document.getElementById('toggleFiltersText1');
    const toggleFiltersIcon1 = document.getElementById('toggleFiltersIcon1');

    toggleFiltersLink1.addEventListener('click', () => {
        filtersForm1.classList.toggle('hidden');

        if (filtersForm1.classList.contains('hidden')) {
            toggleFiltersText1.textContent = 'Filtros';
            toggleFiltersIcon1.classList.remove('rotate-180');
        } else {
            toggleFiltersText1.textContent = 'Esconder Filtros';
            toggleFiltersIcon1.classList.add('rotate-180');
        }
    });
</script>
