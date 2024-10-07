<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meus Pets Registrados') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                {{-- Pets Disponíveis --}}
                <div class="bg-gray-200 p-3 rounded mb-6">
                    <h3 class="text-2xl font-semibold">Pets Disponíveis para Adoção</h3>
                </div>
                @if ($availablePets->isEmpty())
                    <p class="text-gray-600">Você não possui pets disponíveis para adoção.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                        @foreach ($availablePets as $pet)
                            <a href="{{ route('pets.show', $pet->id) }}" class="block hover:shadow-lg transition-shadow duration-300">
                                <x-pet-card :pet="$pet" />
                            </a>
                        @endforeach
                    </div>
                @endif

                {{-- Pets Adotados --}}
                <div class="bg-gray-200 p-3 rounded mb-6">
                    <h3 class="text-2xl font-semibold">Pets Adotados</h3>
                </div>
                @if ($adoptedPets->isEmpty())
                    <p class="text-gray-600">Você ainda não possui pets adotados.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                        @foreach ($adoptedPets as $pet)
                            <a href="{{ route('pets.show', $pet->id) }}" class="block hover:shadow-lg transition-shadow duration-300">
                                <x-pet-card :pet="$pet" />
                            </a>
                        @endforeach
                    </div>
                @endif

                {{-- Pets Favoritados --}}
                <div class="bg-gray-200 p-3 rounded mb-6">
                    <h3 class="text-2xl font-semibold">Pets Favoritados por Outros Usuários</h3>
                </div>
                @if ($favoritedPets->isEmpty())
                    <p class="text-gray-600">Nenhum dos seus pets foi favoritado por outros usuários.</p>
                @else
                    <div class="bg-white border rounded-lg overflow-hidden shadow-sm p-6">
                        <ul class="list-disc list-inside">
                            @foreach ($favoritedPets as $pet)
                                <li class="mb-4">
                                    <a href="{{ route('pets.show', $pet->id) }}" class="text-blue-600 hover:underline font-semibold">
                                        {{ $pet->name }}
                                    </a>
                                    - Favoritado {{ $favoritesCount[$pet->id] ?? 0 }} vez(es)
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
