<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulário para adotar ') . $pet->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <form id="adoptionForm" action="{{ route('adoption-form.store', $pet->id) }}" method="POST"
                    onsubmit="return confirmSubmit()">
                    @csrf

                    <!-- Nome do Pet, Espécie e Nome do Tutor -->
                    <h3 class="font-semibold text-lg mb-4">{{ __('Informações do Pet e Tutor') }}</h3>

                    <div class="mb-4">
                        <x-label for="pet_info" :value="__('Nome do Pet')" />
                        <x-input id="pet_info" class="block mt-1 w-full" type="text" value="{{ $pet->name }}"
                            readonly />
                    </div>

                    <div class="mb-4">
                        <x-label for="species" :value="__('Espécie do Pet')" />
                        <x-input id="species" class="block mt-1 w-full" type="text"
                        value="{{ $pet->species == 'other' ?  $pet->specify_other : __('pets.species_list.' . $pet->species) }}"
                        readonly />


                    </div>


                    <div class="mb-4">
                        <x-label for="responsible_name" :value="__('Cadastrado por:')" />
                        <x-input id="responsible_name" class="block mt-1 w-full" type="text"
                            value="{{ $responsibleName }}" readonly />
                    </div>


                    <!-- Nome Completo do Solicitante -->
                    <h3 class="font-semibold text-lg mb-4">{{ __('Informações Pessoais do Solicitante') }}</h3>
                    <div class="mb-4">
                        <x-label for="full_name" :value="__('Nome Completo')" />
                        <x-input id="full_name" name="full_name" type="text" class="block mt-1 w-full"
                            value="{{ old('full_name') }}" />
                        @error('full_name')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- CPF -->
                    <div class="mb-4">
                        <x-label for="cpf" :value="__('CPF')" />
                        <x-input id="cpf" name="cpf" type="text" class="block mt-1 w-full"
                            value="{{ old('cpf') }}" />
                        @error('cpf')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Data de Nascimento -->
                    <div class="mb-4">
                        <x-label for="birth_date" :value="__('Data de Nascimento')" />
                        <x-input id="birth_date" name="birth_date" type="date" class="block mt-1 w-full"
                            value="{{ old('birth_date') }}" />
                        @error('birth_date')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Endereço -->
                    <div class="mb-4">
                        <x-label for="cep" :value="__('CEP')" />
                        <x-input id="cep" name="cep" type="text" class="block mt-1 w-full"
                            value="{{ old('cep') }}" />
                        @error('cep')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="city" :value="__('Cidade')" />
                        <x-input id="city" name="city" type="text" class="block mt-1 w-full"
                            value="{{ old('city') }}" />
                        @error('city')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="state" :value="__('Estado')" />
                        <x-input id="state" name="state" type="text" class="block mt-1 w-full"
                            value="{{ old('state') }}" />
                        @error('state')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="street" :value="__('Rua')" />
                        <x-input id="street" name="street" type="text" class="block mt-1 w-full"
                            value="{{ old('street') }}" />
                        @error('street')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="number" :value="__('Número')" />
                        <x-input id="number" name="number" type="text" class="block mt-1 w-full"
                            value="{{ old('number') }}" />
                        @error('number')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="complement" :value="__('Complemento')" />
                        <x-input id="complement" name="complement" type="text" class="block mt-1 w-full"
                            value="{{ old('complement') }}" />
                        @error('complement')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <x-label for="neighborhood" :value="__('Bairro')" />
                        <x-input id="neighborhood" name="neighborhood" type="text" class="block mt-1 w-full"
                            value="{{ old('neighborhood') }}" />
                        @error('neighborhood')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Telefone -->
                    <div class="mb-4">
                        <x-label for="phone" :value="__('Telefone')" />
                        <x-input id="phone" name="phone" type="text" class="block mt-1 w-full"
                            value="{{ old('phone') }}" />
                        @error('phone')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <x-label for="email" :value="__('Email')" />
                        <x-input id="email" name="email" type="email" class="block mt-1 w-full"
                            value="{{ old('email') }}" />
                        @error('email')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Estado Civil -->
                    <div class="mb-4">
                        <x-label for="marital_status" :value="__('Estado Civil')" />
                        <x-input id="marital_status" name="marital_status" type="text" class="block mt-1 w-full"
                            value="{{ old('marital_status') }}" />
                        @error('marital_status')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Profissão -->
                    <div class="mb-4">
                        <x-label for="profession" :value="__('Profissão')" />
                        <x-input id="profession" name="profession" type="text" class="block mt-1 w-full"
                            value="{{ old('profession') }}" />
                        @error('profession')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Informações sobre a Casa -->
                    <h3 class="font-semibold text-lg mb-4">{{ __('Informações sobre a Casa') }}</h3>

                    <!-- Tipo de Residência -->
                    <div class="mb-4">
                        <x-label for="residence_type" :value="__('Tipo de Residência')" />
                        <select id="residence_type" name="residence_type"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>
                            <option value="house" {{ old('residence_type') == 'house' ? 'selected' : '' }}>Casa
                            </option>
                            <option value="apartment" {{ old('residence_type') == 'apartment' ? 'selected' : '' }}>
                                Apartamento</option>
                        </select>
                        @error('residence_type')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Propriedade da Residência -->
                    <div class="mb-4">
                        <x-label for="residence_ownership" :value="__('Propriedade da Residência')" />
                        <select id="residence_ownership" name="residence_ownership"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>
                            <option value="owned" {{ old('residence_ownership') == 'owned' ? 'selected' : '' }}>
                                Própria</option>
                            <option value="rented" {{ old('residence_ownership') == 'rented' ? 'selected' : '' }}>
                                Alugada</option>
                        </select>
                        @error('residence_ownership')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Espaço Externo -->
                    <div class="mb-4">
                        <x-label for="outdoor_space" :value="__('Você possui espaço externo?')" />
                        <select id="outdoor_space" name="outdoor_space"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>
                            <option value="0" {{ old('outdoor_space') == '0' ? 'selected' : '' }}>Não</option>
                            <option value="1" {{ old('outdoor_space') == '1' ? 'selected' : '' }}>Sim</option>
                        </select>
                        @error('outdoor_space')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Medidas de Segurança -->
                    <div class="mb-4">
                        <x-label for="safety_measures" :value="__('Você possui medidas de segurança (cercas, portões, etc.)?')" />
                        <select id="safety_measures" name="safety_measures"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>
                            <option value="0" {{ old('safety_measures') == '0' ? 'selected' : '' }}>Não</option>
                            <option value="1" {{ old('safety_measures') == '1' ? 'selected' : '' }}>Sim</option>
                        </select>
                        @error('safety_measures')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Número de Moradores -->
                    <div class="mb-4">
                        <x-label for="number_of_residents" :value="__('Número de Moradores')" />
                        <x-input id="number_of_residents" name="number_of_residents" type="number"
                            class="block mt-1 w-full" value="{{ old('number_of_residents') }}" />
                        @error('number_of_residents')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tem Crianças -->
                    <div class="mb-4">
                        <x-label for="has_children" :value="__('Você possui crianças?')" />
                        <select id="has_children" name="has_children"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>
                            <option value="0" {{ old('has_children') == '0' ? 'selected' : '' }}>Não</option>
                            <option value="1" {{ old('has_children') == '1' ? 'selected' : '' }}>Sim</option>
                        </select>
                        @error('has_children')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Detalhes das Crianças -->
                    <div class="mb-4" id="children_details_section"
                        style="display: {{ old('has_children') == '1' ? 'block' : 'none' }}">
                        <x-label for="children_details" :value="__('Detalhes sobre suas crianças (idade, etc.)')" />
                        <textarea id="children_details" name="children_details"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('children_details') }}</textarea>
                        @error('children_details')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Possui Outros Pets -->
                    <div class="mb-4">
                        <x-label for="has_other_pets" :value="__('Você possui outros pets?')" />
                        <select id="has_other_pets" name="has_other_pets"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>
                            <option value="0" {{ old('has_other_pets') == '0' ? 'selected' : '' }}>Não</option>
                            <option value="1" {{ old('has_other_pets') == '1' ? 'selected' : '' }}>Sim</option>
                        </select>
                        @error('has_other_pets')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Detalhes dos Outros Pets -->
                    <div class="mb-4" id="other_pets_details_section"
                        style="display: {{ old('has_other_pets') == '1' ? 'block' : 'none' }}">
                        <x-label for="other_pets_details" :value="__('Detalhes sobre seus outros pets')" />
                        <textarea id="other_pets_details" name="other_pets_details"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('other_pets_details') }}</textarea>
                        @error('other_pets_details')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Motivação e Expectativas -->
                    <h3 class="font-semibold text-lg mb-4">{{ __('Motivação e Expectativas') }}</h3>

                    <!-- Motivação -->
                    <div class="mb-4">
                        <x-label for="adoption_reason" :value="__('Por que você quer adotar este pet?')" />
                        <textarea id="adoption_reason" name="adoption_reason"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>{{ old('adoption_reason') }}</textarea>
                        @error('adoption_reason')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Termos de Aceitação -->
                    <h3 class="font-semibold text-lg mb-4">{{ __('Termos de Aceitação') }}</h3>

                    <!-- Compromisso a Longo Prazo -->
                    <div class="mb-4">
                        <input type="hidden" name="long_term_commitment" value="0">
                        <div class="flex items-center">
                            <input type="checkbox" id="long_term_commitment" name="long_term_commitment"
                                value="1"
                                class="h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                {{ old('long_term_commitment') ? 'checked' : '' }}>
                            <label for="long_term_commitment" class="ml-2 block text-sm text-gray-700">
                                {{ __('Estou disposto a me comprometer a longo prazo') }}
                            </label>
                        </div>
                        @error('long_term_commitment')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- Disposto a Castrar -->
                    <div class="mb-4">
                        <input type="hidden" name="willing_to_castrate" value="0">
                        <div class="flex items-center">
                            <input type="checkbox" id="willing_to_castrate" name="willing_to_castrate"
                                value="1"
                                class="h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                {{ old('willing_to_castrate') ? 'checked' : '' }}>
                            <label for="willing_to_castrate" class="ml-2 block text-sm text-gray-700">
                                {{ __('Estou disposto a castrar o animal se necessário') }}
                            </label>
                        </div>
                        @error('willing_to_castrate')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Aceitar Visitas Futuras -->
                    <div class="mb-4">
                        <input type="hidden" name="accept_future_visits" value="0">
                        <div class="flex items-center">
                            <input type="checkbox" id="accept_future_visits" name="accept_future_visits"
                                value="1"
                                class="h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                {{ old('accept_future_visits') ? 'checked' : '' }}>
                            <label for="accept_future_visits" class="ml-2 block text-sm text-gray-700">
                                {{ __('Aceito futuras visitas para acompanhamento') }}
                            </label>
                        </div>
                        @error('accept_future_visits')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Declaração de Veracidade -->
                    <div class="mb-4">
                        <input type="hidden" name="declaration_of_truth" value="0">
                        <div class="flex items-center">
                            <input type="checkbox" id="declaration_of_truth" name="declaration_of_truth"
                                value="1"
                                class="h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                {{ old('declaration_of_truth') ? 'checked' : '' }}>
                            <label for="declaration_of_truth" class="ml-2 block text-sm text-gray-700">
                                {{ __('Declaro que todas as informações são verdadeiras') }}
                            </label>
                        </div>
                        @error('declaration_of_truth')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botão de Enviar -->
                    <div class="flex items-center justify-end mt-4">
                        <x-button type="submit" class="ml-4">
                            {{ __('Enviar Formulário') }}
                        </x-button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hasOtherPets = document.getElementById('has_other_pets');
            const otherPetsDetailsSection = document.getElementById('other_pets_details_section');

            // Função para exibir ou ocultar a seção de detalhes
            function toggleOtherPetsDetails() {
                if (hasOtherPets.value == '1') { // 1 significa "Yes"
                    otherPetsDetailsSection.style.display = 'block';
                } else {
                    otherPetsDetailsSection.style.display = 'none';
                }
            }

            // Chama a função ao carregar a página (para carregar o estado correto)
            toggleOtherPetsDetails();

            // Chama a função quando o usuário mudar o valor do select
            hasOtherPets.addEventListener('change', toggleOtherPetsDetails);
        });


        document.getElementById('confirmButton').addEventListener('click', function(event) {
            // Prevenir o comportamento padrão do botão de submit temporariamente
            event.preventDefault();



            // Verificar se todos os termos foram aceitos
            const checkboxes = document.querySelectorAll('input[type="checkbox"][required]');
            let allChecked = true;

            checkboxes.forEach(function(checkbox) {
                if (!checkbox.checked) {
                    allChecked = false;
                }
            });

            if (!allChecked) {
                alert('Você deve aceitar todos os termos antes de enviar o formulário.');
                return;
            }

            // Pergunta de confirmação
            const confirmed = confirm('Você realmente deseja enviar o formulário?');

            if (confirmed) {
                // Submeter o formulário se confirmado
                document.getElementById('adoptionForm').submit();
            }
        });
    </script>

    <script>
        document.getElementById('cep').addEventListener('blur', function() {
            const cep = this.value.replace(/\D/g, '');
            if (cep.length === 8) {
                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('city').value = data.localidade;
                            document.getElementById('state').value = data.uf;
                        } else {
                            alert('CEP inválido.');
                        }
                    })
                    .catch(() => alert('Erro ao buscar informações do CEP.'));
            } else {
                alert('CEP inválido.');
            }
        });
    </script>



    <!-- JavaScript para confirmar o envio do formulário -->
    <script>
        function confirmSubmit() {
            return confirm('Você tem certeza que deseja enviar o formulário?');
        }
    </script>

</x-app-layout>
