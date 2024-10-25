<div>
    {{-- Lista de Pets Adotados --}}
    <div class="bg-gray-200 p-2 rounded flex justify-between items-center">
        <h3 class="text-xl font-semibold">Pets Adotados ({{ $adoptedPets->total() }})</h3>
    </div>

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

    <!-- Formulário de Filtro - Ocultado inicialmente -->
    <div id="filtersForm" class="bg-gray-100 p-2 rounded mb-6 hidden">
        <div class="flex flex-wrap gap-2">
            <!-- Buscar por nome -->
            <div class="flex flex-col">
                <x-label for="searchName" value="Nome" />
                <input type="text" wire:model.defer="searchNameTemp" placeholder="Buscar por nome"
                    class="block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm min-w-max w-full px-4 py-2" />
            </div>

            <!-- Gênero -->
            <div class="flex flex-col">
                <x-label for="searchGender" value="Gênero" />
                <select wire:model.defer="searchGenderTemp"
                    class="block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm min-w-max w-full px-4 py-2">
                    <option value="">Todos</option>
                    <option value="male">Macho</option>
                    <option value="female">Fêmea</option>
                </select>
            </div>

            <!-- Espécie -->
            <div class="flex flex-col">
                <x-label for="searchSpecies" value="Espécie" />
                <select wire:model.defer="searchSpeciesTemp"
                    class="block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm min-w-max w-full px-4 py-2">
                    <option value="">Todas</option>
                    <option value="dog">Cachorro</option>
                    <option value="cat">Gato</option>
                    <option value="other">Outro</option>
                </select>
            </div>

            <!-- Botão de busca -->
            <div class="flex items-end">
                <x-button wire:click="applyFilters" class="flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700">
                    <i class="fas fa-search text-white m-1"></i>
                </x-button>
            </div>
        </div>
    </div>

    @if ($adoptedPets->isEmpty())
        <p class="text-gray-600 mb-4">Nenhum pet.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @foreach ($adoptedPets as $pet)
                <a href="{{ route('pets.show', $pet->id) }}"
                    class="block hover:shadow-lg transition-shadow duration-300">
                    <x-pet-card :pet="$pet" />
                </a>
            @endforeach
        </div>
        <div class="mt-6">
            {{ $adoptedPets->links() }}
        </div>
    @endif


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
</div>
