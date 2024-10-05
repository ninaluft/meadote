<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Evento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data" aria-label="Formulário para editar evento">
                    @csrf
                    @method('PUT')

                    <!-- Título do Evento -->
                    <div class="mb-4">
                        <x-label for="title" value="{{ __('Título do Evento') }}" />
                        <x-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $event->title }}" required />
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Descrição do Evento -->
                    <div class="mb-4">
                        <x-label for="description" value="{{ __('Descrição do Evento') }}" />
                        <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" rows="4" required>{{ $event->description }}</textarea>
                        @error('description')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Data do Evento -->
                    <div class="mb-4">
                        <x-label for="event_date" value="{{ __('Data do Evento') }}" />
                        <x-input id="event_date" class="block mt-1 w-full" type="date" name="event_date" value="{{ $event->event_date }}" required />
                        @error('event_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Campos CEP, Cidade e Estado -->
                    <div class="mb-4">
                        <x-label for="cep" value="{{ __('CEP') }}" />
                        <x-input id="cep" class="block mt-1 w-full" type="text" name="cep" value="{{ $event->cep }}" required />
                        @error('cep')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="city" value="{{ __('Cidade') }}" />
                        <x-input id="city" class="block mt-1 w-full" type="text" name="city" value="{{ $event->city }}" required />
                        @error('city')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="state" value="{{ __('Estado') }}" />
                        <x-input id="state" class="block mt-1 w-full" type="text" name="state" value="{{ $event->state }}" required />
                        @error('state')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Local do Evento -->
                    <div class="mb-4">
                        <x-label for="location" value="{{ __('Local do Evento') }}" />
                        <x-input id="location" class="block mt-1 w-full" type="text" name="location" value="{{ $event->location }}" required />
                        @error('location')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Foto do Evento -->
                    <div class="mb-4">
                        <x-label for="photo" value="{{ __('Foto do Evento') }}" />
                        <input type="file" name="photo" id="photo" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        @if ($event->photo_path)
                            <img src="{{ asset('storage/' . $event->photo_path) }}" alt="Foto atual do evento" class="mt-4 w-32 h-32 rounded-lg object-cover">
                        @endif
                        @error('photo')
                            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botão Atualizar Evento -->
                    <x-button class="mt-4">
                        {{ __('Atualizar Evento') }}
                    </x-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
