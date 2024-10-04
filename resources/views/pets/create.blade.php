<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadastro de Novo Pet') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Pet Registration Form -->
                <form action="{{ route('pets.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Pet Name -->
                    <div class="mb-4">
                        <x-label for="name" :value="__('Nome do Pet')" />
                        <x-input id="name"
                            class="block mt-1 w-full border-gray-300  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" maxlength="100"
                            type="text" name="name" :value="old('name')" required autofocus />
                    </div>

                    <!-- Photos -->
                    <div class="mb-4">
                        <x-label for="photo_path" :value="__('Foto do Pet')" />
                        <x-input id="photo_path"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            type="file" name="photo_path" accept="image/*" multiple onchange="previewImage()" />
                    </div>

                    <!-- Image Preview -->
                    <div class="mb-4" id="image_preview" style="display: none;">
                        <x-label :value="__('Pré-visualização da Foto')" />
                        <img id="preview" class="mt-2 max-w-xs rounded-md shadow-md" src="#"
                            alt="Pré-visualização da Foto" />
                    </div>

                    <!-- Species -->
                    <div class="mb-4">
                        <x-label for="species" :value="__('Espécie')" />
                        <select id="species" name="species"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500  focus:ring-indigo-500 rounded-md shadow-sm"
                            required onchange="toggleSpecifyOther(this.value)" maxlength="50">
                            <option value="dog">{{ __('Cachorro') }}</option>
                            <option value="cat">{{ __('Gato') }}</option>
                            <option value="other">{{ __('Outro') }}</option>
                        </select>
                    </div>

                    <!-- Specify Other Species -->
                    <div id="specify_other_field" class="mb-4" style="display: none;">
                        <x-label for="specify_other" :value="__('Especifique a Espécie')" />
                        <x-input id="specify_other" name="specify_other" type="text"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" maxlength="1000" />
                    </div>


                    <!-- Gender -->
                    <div class="mb-4">
                        <x-label for="gender" :value="__('Sexo')" />
                        <select id="gender" name="gender"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>
                            <option value="male">{{ __('Macho') }}</option>
                            <option value="female">{{ __('Fêmea') }}</option>
                        </select>
                    </div>

                    <!-- Age -->
                    <div class="mb-4">
                        <x-label for="age" :value="__('Idade Aproximada')" />
                        <select id="age" name="age"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>
                            <option value="puppy">{{ __('Filhote') }}</option>
                            <option value="adult">{{ __('Adulto') }}</option>
                            <option value="senior">{{ __('Sênior') }}</option>
                        </select>
                    </div>

                    <!-- Size -->
                    <div class="mb-4">
                        <x-label for="size" :value="__('Porte')" />
                        <select id="size" name="size"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>
                            <option value="small">{{ __('Pequeno') }}</option>
                            <option value="medium">{{ __('Médio') }}</option>
                            <option value="large">{{ __('Grande') }}</option>
                        </select>
                    </div>

                    <!-- Neutered -->
                    <div class="mb-4">
                        <x-label for="is_neutered" :value="__('É castrado?')" />
                        <select id="is_neutered" name="is_neutered"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>
                            <option value="1">{{ __('Sim') }}</option>
                            <option value="0">{{ __('Não') }}</option>
                        </select>
                    </div>

                    <!-- Special Conditions -->
                    <div class="mb-4">
                        <x-label for="special_conditions" :value="__('Condições Especiais')" />
                        <select id="special_conditions" name="special_conditions"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            onchange="toggleSpecialConditions(this.value)">
                            <option value="0">{{ __('Não') }}</option>
                            <option value="1">{{ __('Sim') }}</option>
                        </select>
                    </div>

                    <!-- Special Conditions Description -->
                    <div id="special_conditions_description_field" class="mb-4" style="display: none;">
                        <x-label for="special_conditions_description" :value="__('Descrição das Condições Especiais')" />
                        <textarea id="special_conditions_description" name="special_conditions_description"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" maxlength="1000">{{ old('special_conditions_description') }}</textarea>
                    </div>


                    <!-- Description -->
                    <div class="mb-4">
                        <x-label for="description" :value="__('Mais sobre o pet')" />
                        <textarea id="description" name="description"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" maxlength="1000">{{ old('description') }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Cadastrar Pet') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script to show/hide the special conditions description, specify other species, and preview image -->
    <script>
        function toggleSpecialConditions(value) {
            const descriptionField = document.getElementById('special_conditions_description_field');
            descriptionField.style.display = value == 1 ? 'block' : 'none';
        }

        function toggleSpecifyOther(value) {
            const specifyOtherField = document.getElementById('specify_other_field');
            const specifyOtherInput = document.getElementById('specify_other');
            if (value === 'other') {
                specifyOtherField.style.display = 'block';
                specifyOtherInput.setAttribute('required', 'required');
            } else {
                specifyOtherField.style.display = 'none';
                specifyOtherInput.removeAttribute('required');
            }
        }

        function previewImage() {
            const file = document.getElementById('photo_path').files[0];
            const previewContainer = document.getElementById('image_preview');
            const previewImage = document.getElementById('preview');

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.style.display = 'block';
                }

                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
            }
        }

        // Execute on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleSpecialConditions(document.getElementById('special_conditions').value);
            toggleSpecifyOther(document.getElementById('species').value);
        });
    </script>
</x-app-layout>
