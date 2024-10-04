<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Criar Evento') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('events.store') }}" method="POST" aria-label="Formulário para criação de evento">
                    @csrf
                    <div class="mb-4">
                        <x-label for="title" value="{{ __('Título do Evento') }}" />
                        <x-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ old('title') }}" required />
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="description" value="{{ __('Descrição do Evento') }}" />
                        <textarea id="description" name="description" class="block mt-1 w-full" rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="event_date" value="{{ __('Data do Evento') }}" />
                        <x-input id="event_date" class="block mt-1 w-full" type="date" name="event_date" value="{{ old('event_date') }}" required />
                        @error('event_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Campos CEP, Cidade e Estado -->
                    <div class="mb-4">
                        <x-label for="cep" value="{{ __('CEP') }}" />
                        <x-input id="cep" class="block mt-1 w-full" type="text" name="cep" value="{{ old('cep') }}" required />
                        @error('cep')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="city" value="{{ __('Cidade') }}" />
                        <x-input id="city" class="block mt-1 w-full" type="text" name="city" value="{{ old('city') }}" readonly />
                        @error('city')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="state" value="{{ __('Estado') }}" />
                        <x-input id="state" class="block mt-1 w-full" type="text" name="state" value="{{ old('state') }}" readonly />
                        @error('state')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="location" value="{{ __('Local do Evento') }}" />
                        <x-input id="location" class="block mt-1 w-full" type="text" name="location" value="{{ old('location') }}" required />
                        @error('location')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <x-button class="mt-4">
                        {{ __('Criar Evento') }}
                    </x-button>
                </form>
            </div>
        </div>
    </div>

    <!-- Script para buscar cidade e estado usando o CEP -->
    <script>
        document.getElementById('cep').addEventListener('blur', function () {
            const cep = this.value.replace(/\D/g, '');
            if (cep.length === 8) {
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!('erro' in data)) {
                            document.getElementById('city').value = data.localidade;
                            document.getElementById('state').value = data.uf;
                        } else {
                            alert('CEP não encontrado.');
                        }
                    })
                    .catch(error => console.error('Erro ao buscar o CEP:', error));
            } else {
                alert('Por favor, insira um CEP válido.');
            }
        });
    </script>

</x-app-layout>
