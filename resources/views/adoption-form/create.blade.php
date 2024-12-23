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

                    <!-- Informações do Pet e Tutor -->
                    <h3 class="font-semibold text-lg mb-4">{{ __('Informações do Pet e Tutor') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Nome do Pet -->
                        <div class="mb-2">
                            <x-label for="pet_info" :value="__('Nome do Pet')" />
                            <x-input id="pet_info" class="block mt-1 w-full" type="text" value="{{ $pet->name }}"
                                readonly />
                        </div>

                        <!-- Espécie do Pet -->
                        <div class="mb-2">
                            <x-label for="species" :value="__('Espécie do Pet')" />
                            <x-input id="species" class="block mt-1 w-full" type="text"
                                value="{{ $pet->species == 'other' ? $pet->specify_other : __('pets.species_list.' . $pet->species) }}"
                                readonly />
                        </div>

                        <!-- Cadastrado por -->
                        <div class="mb-4">
                            <x-label for="responsible_name" :value="__('Cadastrado por:')" />
                            <x-input id="responsible_name" class="block mt-1 w-full" type="text"
                                value="{{ $responsibleName }}" readonly />
                        </div>
                    </div>

                    <!-- Linha de Separação -->
                    <hr class="my-8 border-gray-300">

                    <!-- Informações Pessoais do Solicitante -->
                    <h3 class="font-semibold text-lg mb-4">{{ __('Informações Pessoais do Solicitante') }}</h3>
                    <div class="mb-4">
                        <x-label for="full_name" :value="__('Nome Completo')" />
                        <x-input id="full_name" name="full_name" type="text" class="block mt-1 w-full"
                            value="{{ old('full_name', $submitterName) }}" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- CPF -->
                        <div class="mb-2">
                            <x-label for="cpf" :value="__('CPF')" />
                            <x-input id="cpf" name="cpf" type="text" class="block mt-1 w-full"
                                value="{{ old('cpf', $submitterCpf) }}" />
                            <p id="cpfError" class="text-red-500 text-sm mt-2" style="display: none;">CPF inválido.</p>
                            @error('cpf')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Data de Nascimento -->
                        <div class="mb-2">
                            <x-label for="birth_date" :value="__('Data de Nascimento')" />
                            <x-input id="birth_date" name="birth_date" type="date" class="block mt-1 w-full"
                                value="{{ old('birth_date') }}" />
                            @error('birth_date')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Estado Civil -->
                        <div class="mb-2">
                            <x-label for="marital_status" :value="__('Estado Civil')" />
                            <x-input id="marital_status" name="marital_status" type="text" class="block mt-1 w-full"
                                value="{{ old('marital_status') }}" />
                            @error('marital_status')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Profissão -->
                        <div class="mb-2">
                            <x-label for="profession" :value="__('Profissão')" />
                            <x-input id="profession" name="profession" type="text" class="block mt-1 w-full"
                                value="{{ old('profession') }}" />
                            @error('profession')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Telefone -->
                        <div class="mb-2">
                            <x-label for="phone" :value="__('Telefone')" />
                            <x-input id="phone" name="phone" type="text" class="block mt-1 w-full"
                                value="{{ old('phone') }}" />
                            @error('phone')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-2">
                            <x-label for="email" :value="__('Email')" />
                            <x-input id="email" name="email" type="email" class="block mt-1 w-full"
                                value="{{ old('email', Auth::user()->email) }}" />
                            @error('email')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Linha de Separação -->
                    <hr class="my-8 border-gray-300">

                    <!-- Endereço -->
                    <h3 class="font-semibold text-lg mb-4">{{ __('Endereço') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- CEP -->
                        <div class="mb-2">
                            <x-label for="cep" :value="__('CEP')" />
                            <x-input id="cep" name="cep" type="text" class="block mt-1 w-full"
                                value="{{ old('cep', Auth::user()->cep) }}" />
                            @error('cep')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cidade -->
                        <div class="mb-2">
                            <x-label for="city" :value="__('Cidade')" />
                            <x-input id="city" name="city" type="text" class="block mt-1 w-full"
                                value="{{ old('city', Auth::user()->city) }}" />
                            @error('city')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div class="mb-2">
                            <x-label for="state" :value="__('Estado')" />
                            <x-input id="state" name="state" type="text" class="block mt-1 w-full"
                                value="{{ old('state', Auth::user()->state) }}" />
                            @error('state')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Rua -->
                    <div class="mb-4">
                        <x-label for="street" :value="__('Rua')" />
                        <x-input id="street" name="street" type="text" class="block mt-1 w-full"
                            value="{{ old('street') }}" />
                        @error('street')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Número -->
                        <div class="mb-2">
                            <x-label for="number" :value="__('Número')" />
                            <x-input id="number" name="number" type="text" class="block mt-1 w-full"
                                value="{{ old('number') }}" />
                            @error('number')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Complemento -->
                        <div class="mb-2">
                            <x-label for="complement" :value="__('Complemento')" />
                            <x-input id="complement" name="complement" type="text" class="block mt-1 w-full"
                                value="{{ old('complement') }}" />
                            @error('complement')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bairro -->
                        <div class="mb-2">
                            <x-label for="neighborhood" :value="__('Bairro')" />
                            <x-input id="neighborhood" name="neighborhood" type="text" class="block mt-1 w-full"
                                value="{{ old('neighborhood') }}" />
                            @error('neighborhood')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>


                    <!-- Linha de Separação -->
                    <hr class="my-8  border-gray-300">

                    <!-- Informações sobre a Casa -->
                    <h3 class="font-semibold text-lg mb-4">{{ __('Informações sobre a Casa') }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Tipo de Residência -->
                        <div class="mb-4">
                            <x-label for="residence_type" :value="__('Tipo de Residência')" />
                            <select id="residence_type" name="residence_type"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>
                                <option value="house" {{ old('residence_type') == 'house' ? 'selected' : '' }}>Casa
                                </option>
                                <option value="apartment"
                                    {{ old('residence_type') == 'apartment' ? 'selected' : '' }}>Apartamento</option>
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
                                <option value="0" {{ old('outdoor_space') == '0' ? 'selected' : '' }}>Não
                                </option>
                                <option value="1" {{ old('outdoor_space') == '1' ? 'selected' : '' }}>Sim
                                </option>
                            </select>
                            @error('outdoor_space')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Medidas de Segurança -->
                        <div class="mb-4">
                            <x-label for="safety_measures" :value="__('Você possui medidas de segurança (cercas, portões, etc.)?')" />
                            <select id="safety_measures" name="safety_measures"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>
                                <option value="0" {{ old('safety_measures') == '0' ? 'selected' : '' }}>Não
                                </option>
                                <option value="1" {{ old('safety_measures') == '1' ? 'selected' : '' }}>Sim
                                </option>
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
                    </div>

                    <!-- Children details section, aligned underneath, visible when required -->
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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <x-label for="has_other_pets" :value="__('Você possui outros pets?')" />
                            <select id="has_other_pets" name="has_other_pets"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>
                                <option value="0" {{ old('has_other_pets') == '0' ? 'selected' : '' }}>Não
                                </option>
                                <option value="1" {{ old('has_other_pets') == '1' ? 'selected' : '' }}>Sim
                                </option>
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
                    </div>

                    <!-- Linha de Separação -->
                    <hr class="my-8  border-gray-300">

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

                    <!-- Linha de Separação -->
                    <hr class="my-8  border-gray-300">

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
                if (hasOtherPets && hasOtherPets.value == '1') { // 1 significa "Yes"
                    otherPetsDetailsSection.style.display = 'block';
                } else {
                    otherPetsDetailsSection.style.display = 'none';
                }
            }

            // Chama a função ao carregar a página (para carregar o estado correto)
            if (hasOtherPets) {
                toggleOtherPetsDetails();
                // Chama a função quando o usuário mudar o valor do select
                hasOtherPets.addEventListener('change', toggleOtherPetsDetails);
            }

            // Verifica se o botão de confirmação existe antes de adicionar o evento
            const confirmButton = document.getElementById('confirmButton');
            if (confirmButton) {
                confirmButton.addEventListener('click', function(event) {
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


    <script>
        // Função para validar o CPF
        function validarCPF(cpf) {
            cpf = cpf.replace(/[^\d]+/g, '');
            if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;
            let soma = 0,
                resto;
            for (let i = 1; i <= 9; i++) soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
            resto = (soma * 10) % 11;
            if ((resto === 10) || (resto === 11)) resto = 0;
            if (resto !== parseInt(cpf.substring(9, 10))) return false;
            soma = 0;
            for (let i = 1; i <= 10; i++) soma += parseInt(cpf.substring(i - 1, i)) * (12 - i);
            resto = (soma * 10) % 11;
            if ((resto === 10) || (resto === 11)) resto = 0;
            return resto === parseInt(cpf.substring(10, 11));
        }

        // Evento de validação ao sair do campo CPF
        document.getElementById('cpf').addEventListener('blur', function() {
            const cpf = this.value;
            const cpfError = document.getElementById('cpfError');

            if (!validarCPF(cpf)) {
                cpfError.style.display = 'block';
                this.classList.add('border-red-500');
            } else {
                cpfError.style.display = 'none';
                this.classList.remove('border-red-500');
            }
        });

        // Remove mensagem de erro ao focar em qualquer outro campo do formulário
        document.getElementById('adoptionForm').addEventListener('focusin', function(event) {
            if (event.target.id !== 'cpf') {
                document.getElementById('cpfError').style.display = 'none';
            }
        });
    </script>

</x-app-layout>
