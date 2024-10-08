<div>
    {{-- Lista de Pets Disponíveis --}}
    <div class="bg-gray-200 p-2 rounded flex justify-between items-center ">
        <h3 class="text-xl font-semibold">Pets Disponíveis para Adoção ({{ $availablePets->total() }})</h3>

        <a href="{{ route('pets.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">
            + Adicionar Pet
        </a>
    </div>

    {{-- Formulário de Filtro --}}
    <div class="bg-gray-100 p-2 rounded mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <input type="text" wire:model="searchName" placeholder="Buscar por nome"
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div>
                <select wire:model="searchGender"
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos os Gêneros</option>
                    <option value="male">Macho</option>
                    <option value="female">Fêmea</option>
                </select>
            </div>
            <div>
                <select wire:model="searchSpecies"
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todas as Espécies</option>
                    <option value="dog">Cachorro</option>
                    <option value="cat">Gato</option>
                    <option value="other">Outro</option>
                </select>
            </div>
            <div>
                <button wire:click="applyFilters"
                    class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">
                    Buscar
                </button>
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
