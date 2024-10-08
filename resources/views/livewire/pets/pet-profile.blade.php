<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
</div>
<div>
    <!-- Exibir informações do pet -->
    <div class="relative py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 relative">
                <div class="flex flex-col md:flex-row">

                    <!-- Foto do Pet -->
                    <div class="md:w-1/3">
                        <img src="{{ $pet->photo_path ? asset('storage/' . $pet->photo_path) : asset('images/default-pet.jpg') }}"
                            alt="Foto do pet {{ $pet->name }}" class="rounded-lg w-full h-auto">
                    </div>

                    <!-- Detalhes do Pet -->
                    <div class="md:w-2/3 md:ml-6">
                        <div class="flex justify-between items-center">
                            <h2 class="text-2xl font-semibold">{{ $pet->name }}</h2>

                            <!-- Favoritar Pet -->
                            @auth
                                <x-favorite-button :petId="$pet->id" :isFavorited="Auth::user()->hasFavorited($pet)" aria-label="{{ Auth::user()->hasFavorited($pet) ? 'Remover dos favoritos' : 'Adicionar aos favoritos' }}" />
                            @endauth
                        </div>

                        <p class="text-gray-600">Espécie: {{ ucfirst($pet->species) }}</p>
                        <p class="text-gray-600">Gênero: {{ ucfirst($pet->gender) }}</p>
                        <p class="text-gray-600">Idade: {{ ucfirst($pet->age) }}</p>
                        <p class="text-gray-600">Porte: {{ ucfirst($pet->size) }}</p>
                        <p class="text-gray-600">Castrado: {{ $pet->is_neutered ? 'Sim' : 'Não' }}</p>

                        <!-- Mais detalhes... -->
                        <p class="text-gray-600 mt-4">{{ $pet->description }}</p>
                    </div>
                </div>

                <!-- Navegação entre Pets -->
                @if ($previousPetId)
                    <button wire:click="loadPreviousPet" class="absolute left-0 top-1/2 transform -translate-y-1/2 bg-gray-200 p-4 rounded-full shadow-lg">
                        &larr;
                    </button>
                @endif

                @if ($nextPetId)
                    <button wire:click="loadNextPet" class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-200 p-4 rounded-full shadow-lg">
                        &rarr;
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
