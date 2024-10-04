<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Pet') }}
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

                <form action="{{ route('pets.update', $pet->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Nome -->
                    <div class="mb-4">
                        <x-label for="name" :value="__('Nome')" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $pet->name)" required autofocus  maxlength="100"/>
                    </div>

                    <!-- Foto -->
                    <div class="mb-4">
                        <x-label for="photo_path" :value="__('Foto')" />
                        <x-input id="photo_path" class="block mt-1 w-full" type="file" name="photo_path" accept="image/*" />
                        @if ($pet->photo_path)
                            <img src="{{ asset('storage/' . $pet->photo_path) }}" class="mt-2" alt="{{ $pet->name }}" style="max-width: 150px;">
                        @endif
                    </div>

                    <!-- Espécie -->
                    <div class="mb-4">
                        <x-label for="species" :value="__('Espécie')" />
                        <select id="species" name="species" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required onchange="toggleSpecifyOther(this.value)">
                            <option value="dog" {{ old('species', $pet->species) == 'dog' ? 'selected' : '' }}>{{ __('Cachorro') }}</option>
                            <option value="cat" {{ old('species', $pet->species) == 'cat' ? 'selected' : '' }}>{{ __('Gato') }}</option>
                            <option value="other" {{ old('species', $pet->species) == 'other' ? 'selected' : '' }}>{{ __('Outro') }}</option>
                        </select>
                    </div>

                    <!-- Specify Other Species -->
                    <div id="specify_other_field" class="mb-4" style="{{ old('species', $pet->species) == 'other' ? 'display: block;' : 'display: none;' }}">
                        <x-label for="specify_other" :value="__('Especifique a Espécie')" />
                        <x-input id="specify_other" name="specify_other" type="text" class="block mt-1 w-full" :value="old('specify_other', $pet->specify_other)" maxlength="1000"/>
                    </div>

                    <!-- Sexo -->
                    <div class="mb-4">
                        <x-label for="gender" :value="__('Sexo')" />
                        <select id="gender" name="gender" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="male" {{ old('gender', $pet->gender) == 'male' ? 'selected' : '' }}>{{ __('Macho') }}</option>
                            <option value="female" {{ old('gender', $pet->gender) == 'female' ? 'selected' : '' }}>{{ __('Fêmea') }}</option>
                        </select>
                    </div>

                    <!-- Idade Aproximada -->
                    <div class="mb-4">
                        <x-label for="age" :value="__('Idade Aproximada')" />
                        <select id="age" name="age" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="puppy" {{ old('age', $pet->age) == 'puppy' ? 'selected' : '' }}>{{ __('Filhote') }}</option>
                            <option value="adult" {{ old('age', $pet->age) == 'adult' ? 'selected' : '' }}>{{ __('Adulto') }}</option>
                            <option value="senior" {{ old('age', $pet->age) == 'senior' ? 'selected' : '' }}>{{ __('Sênior') }}</option>
                        </select>
                    </div>

                    <!-- Porte -->
                    <div class="mb-4">
                        <x-label for="size" :value="__('Porte')" />
                        <select id="size" name="size" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="small" {{ old('size', $pet->size) == 'small' ? 'selected' : '' }}>{{ __('Pequeno') }}</option>
                            <option value="medium" {{ old('size', $pet->size) == 'medium' ? 'selected' : '' }}>{{ __('Médio') }}</option>
                            <option value="large" {{ old('size', $pet->size) == 'large' ? 'selected' : '' }}>{{ __('Grande') }}</option>
                        </select>
                    </div>

                    <!-- É castrado? -->
                    <div class="mb-4">
                        <x-label for="is_neutered" :value="__('É castrado?')" />
                        <select id="is_neutered" name="is_neutered" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="0" {{ old('is_neutered', $pet->is_neutered) == '0' ? 'selected' : '' }}>{{ __('Não') }}</option>
                            <option value="1" {{ old('is_neutered', $pet->is_neutered) == '1' ? 'selected' : '' }}>{{ __('Sim') }}</option>
                        </select>
                    </div>

                    <!-- Condições especiais? -->
                    <div class="mb-4">
                        <x-label for="special_conditions" :value="__('Condições especiais?')" />
                        <select id="special_conditions" name="special_conditions" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required onchange="toggleSpecialConditions()">
                            <option value="0" {{ old('special_conditions', $pet->special_conditions) == '0' ? 'selected' : '' }}>{{ __('Não') }}</option>
                            <option value="1" {{ old('special_conditions', $pet->special_conditions) == '1' ? 'selected' : '' }}>{{ __('Sim') }}</option>
                        </select>
                    </div>

                    <!-- Descrição das condições especiais -->
                    <div class="mb-4" id="special_conditions_description_container" style="{{ old('special_conditions', $pet->special_conditions) == '1' ? 'display:block;' : 'display:none;' }}">
                        <x-label for="special_conditions_description" :value="__('Descrição das condições especiais')" />
                        <textarea id="special_conditions_description" name="special_conditions_description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm " maxlength="1000">{{ old('special_conditions_description', $pet->special_conditions_description) }}</textarea>
                    </div>

                    <!-- Mais sobre o pet -->
                    <div class="mb-4">
                        <x-label for="description" :value="__('Mais sobre o pet')" />
                        <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" maxlength="1000">{{ old('description', $pet->description) }}</textarea>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Atualizar Pet') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script para alternar a exibição das condições especiais e espécie -->
    <script>
        function toggleSpecialConditions() {
            var specialConditions = document.getElementById('special_conditions').value;
            var descriptionContainer = document.getElementById('special_conditions_description_container');
            descriptionContainer.style.display = specialConditions === '1' ? 'block' : 'none';
        }

        function toggleSpecifyOther(value) {
            const specifyOtherField = document.getElementById('specify_other_field');
            specifyOtherField.style.display = value == 'other' ? 'block' : 'none';
        }

        // Executa o script ao carregar a página para mostrar os campos corretos caso haja erro de validação
        document.addEventListener('DOMContentLoaded', function() {
            toggleSpecialConditions();
            toggleSpecifyOther(document.getElementById('species').value);
        });
    </script>
</x-app-layout>
