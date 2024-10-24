<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Evento') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Título do Evento -->
                    <div class="mb-4">
                        <x-label for="title" :value="__('Título do Evento')" />
                        <x-input id="title" class="block mt-1 w-full" type="text" name="title"
                            :value="old('title', $event->title)" required autofocus maxlength="100" />
                    </div>


                    <!-- Descrição do Evento -->
                    <div class="mb-4">
                        <x-label for="description" :value="__('Descrição')" />
                        <textarea id="description" name="description"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>{{ old('description', $event->description) }}</textarea>
                    </div>

                    <!-- Data do Evento -->
                    <div class="mb-4">
                        <x-label for="event_date" :value="__('Data do Evento')" />
                        <x-input id="event_date" class="block mt-1 w-full" type="date" name="event_date"
                            :value="old('event_date', $event->event_date)" required />
                    </div>

                    <!-- CEP, Cidade e Estado -->
                    <div class="mb-4">
                        <x-label for="cep" :value="__('CEP')" />
                        <x-input id="cep" class="block mt-1 w-full" type="text" name="cep"
                            :value="old('cep', $event->cep)" required />
                    </div>

                    <div class="mb-4">
                        <x-label for="city" :value="__('Cidade')" />
                        <x-input id="city" class="block mt-1 w-full" type="text" name="city"
                            :value="old('city', $event->city)" required />
                    </div>

                    <div class="mb-4">
                        <x-label for="state" :value="__('Estado')" />
                        <x-input id="state" class="block mt-1 w-full" type="text" name="state"
                            :value="old('state', $event->state)" required />
                    </div>

                    <!-- Local do Evento -->
                    <div class="mb-4">
                        <x-label for="location" :value="__('Local do Evento')" />
                        <x-input id="location" class="block mt-1 w-full" type="text" name="location"
                            :value="old('location', $event->location)" required />
                    </div>


                    <!-- Foto -->
                    <div class="mb-4">
                        <x-label for="photo" :value="__('Foto')" />
                        <x-input id="photo" class="block mt-1 w-full" type="file" name="photo" accept="image/*"
                            onchange="previewImage(event)" />
                        <img id="photo_preview"
                            src="{{ $event->photo_path ? $event->photo_path : asset('images/default.jpg') }}"
                            class="mt-2 w-full max-w-xs h-auto object-cover rounded-lg"
                            alt="Foto do evento {{ $event->name }}">
                    </div>




                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Atualizar Evento') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script para pré-visualizar a nova imagem quando selecionada -->
    <script>
        function previewImage(event) {
            const input = event.target;
            const reader = new FileReader();

            reader.onload = function() {
                const preview = document.getElementById('photo_preview');
                preview.src = reader.result; // Substitui a imagem antiga pela nova pré-visualização
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]); // Lê a imagem selecionada e a exibe
            }
        }
    </script>
</x-app-layout>
