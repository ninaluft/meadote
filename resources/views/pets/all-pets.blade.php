<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Todos os Pets Disponíveis') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Barra de Busca -->
                <form action="{{ route('pets.all-pets') }}" method="GET" class="mb-6">
                    <div class="flex flex-wrap gap-4">
                        <!-- Espécie -->
                        <div class="flex-grow">
                            <x-label for="species" value="Espécie" />
                            <select id="species" name="species"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Todas</option>
                                <option value="dog" {{ request('species') == 'dog' ? 'selected' : '' }}>Cachorro
                                </option>
                                <option value="cat" {{ request('species') == 'cat' ? 'selected' : '' }}>Gato</option>
                                <option value="other" {{ request('species') == 'other' ? 'selected' : '' }}>Outro
                                </option>
                            </select>
                        </div>

                        <!-- Sexo -->
                        <div class="flex-grow">
                            <x-label for="gender" value="Sexo" />
                            <select id="gender" name="gender"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Todos</option>
                                <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Macho
                                </option>
                                <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Fêmea
                                </option>
                            </select>
                        </div>

                        <!-- Porte -->
                        <div class="flex-grow">
                            <x-label for="size" value="Porte" />
                            <select id="size" name="size"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Todos</option>
                                <option value="small" {{ request('size') == 'small' ? 'selected' : '' }}>Pequeno
                                </option>
                                <option value="medium" {{ request('size') == 'medium' ? 'selected' : '' }}>Médio
                                </option>
                                <option value="large" {{ request('size') == 'large' ? 'selected' : '' }}>Grande
                                </option>
                            </select>
                        </div>

                        <!-- Cidade -->
                        <div class="flex-grow">
                            <x-label for="city" value="Cidade" />
                            <x-input id="city"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                type="text" name="city" value="{{ request('city') }}"
                                placeholder="Digite a cidade" />
                        </div>

                        <!-- Idade Aproximada -->
                        <div class="flex-grow">
                            <x-label for="age" value="Idade Aproximada" />
                            <select id="age" name="age"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Todas</option>
                                <option value="puppy" {{ request('age') == 'puppy' ? 'selected' : '' }}>Filhote
                                </option>
                                <option value="adult" {{ request('age') == 'adult' ? 'selected' : '' }}>Adulto
                                </option>
                                <option value="senior" {{ request('age') == 'senior' ? 'selected' : '' }}>Sênior
                                </option>
                            </select>
                        </div>


                        <!-- Castrado -->
                        <div class="flex-grow">
                            <x-label for="is_neutered" value="Castrado" />
                            <select id="is_neutered" name="is_neutered"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Todos</option>
                                <option value="1" {{ request('is_neutered') == '1' ? 'selected' : '' }}>Sim
                                </option>
                                <option value="0" {{ request('is_neutered') == '0' ? 'selected' : '' }}>Não
                                </option>
                            </select>
                        </div>

                        <!-- Botão de Busca -->
                        <div class="flex items-center mt-4">
                            <x-button class="ml-4">
                                {{ __('Buscar') }}
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
</x-app-layout>
