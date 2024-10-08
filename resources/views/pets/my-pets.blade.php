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
                @livewire('pets.available-pets')

                <hr class="my-8 border-t-2 border-gray-300">

                {{-- Pets Adotados --}}
                @livewire('pets.adopted-pets')

                <hr class="my-8 border-t-2 border-gray-300">

                {{-- Pets Favoritados --}}
                @livewire('pets.favorited-pets')
            </div>
        </div>
    </div>
</x-app-layout>
