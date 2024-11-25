<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
                {{ __('Formulário de Adoção para ') . $adoptionForm->pet_name }}
            </h2>

            @if ($adoptionForm->submitter && $adoptionForm->pet && $adoptionForm->pet->user)
                <form
                    action="{{ route('messages.conversation', ['user' => $adoptionForm->submitter_user_id === Auth::id() ? $adoptionForm->pet->user_id : $adoptionForm->submitter_user_id]) }}"
                    method="GET">
                    <x-button type="submit" class="bg-blue-500 hover:bg-blue-600 flex justify-center items-center">
                        {{ __('Iniciar conversa') }}
                    </x-button>
                </form>
            @else
                <p class="text-red-500 font-semibold">
                    {{ __('O usuário associado a este formulário não está mais disponível.') }}
                </p>
            @endif
        </div>
    </x-slot>



    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Informações do Pet -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden p-6 space-y-4">
                <h3 class="font-semibold text-xl text-blue-800 mb-4">{{ __('🐾 Informações do Pet') }}</h3>
                <div class="grid grid-cols-2 gap-4">
                    <p><strong>{{ __('Nome do Pet:') }}</strong> {{ $adoptionForm->pet_name }}</p>
                    <p><strong>{{ __('Espécie:') }}</strong> {{ __('pets.species_list.' . $adoptionForm->species) }}</p>
                    <p><strong>{{ __('Cadastrado por:') }}</strong> {{ $adoptionForm->responsible_user_name }}</p>
                </div>
            </div>

            <!-- Informações do Solicitante -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden p-6 space-y-4">
                <h3 class="font-semibold text-xl text-blue-800 mb-4">{{ __('👤 Informações do Solicitante') }}</h3>
                <div class="grid grid-cols-2 gap-4">
                    <p><strong>{{ __('Nome Completo:') }}</strong> {{ $adoptionForm->submitter_name }}</p>
                    <p><strong>{{ __('CPF:') }}</strong> {{ $adoptionForm->cpf }}</p>
                    <p><strong>{{ __('Data de Nascimento:') }}</strong>
                        {{ \Carbon\Carbon::parse($adoptionForm->birth_date)->format('d/m/Y') }}</p>
                    <p><strong>{{ __('Telefone:') }}</strong> {{ $adoptionForm->phone }}</p>
                    <p><strong>{{ __('Email:') }}</strong> {{ $adoptionForm->email }}</p>
                    <p><strong>{{ __('Estado Civil:') }}</strong> {{ $adoptionForm->marital_status }}</p>
                    <p><strong>{{ __('Profissão:') }}</strong> {{ $adoptionForm->profession }}</p>
                </div>
            </div>

            <!-- Informações do Endereço -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden p-6 space-y-4">
                <h3 class="font-semibold text-xl text-blue-800 mb-4">{{ __('🏠 Informações do Endereço') }}</h3>
                <div class="grid grid-cols-2 gap-4">
                    <p><strong>{{ __('Rua: ') }}</strong> {{ $adoptionForm->street }},
                        {{ $adoptionForm->number }}{{ $adoptionForm->complement ? ', ' . $adoptionForm->complement : '' }}
                    </p>
                    <p><strong>{{ __('Bairro:') }}</strong> {{ $adoptionForm->neighborhood }}</p>
                    <p><strong>{{ __('CEP:') }}</strong> {{ $adoptionForm->cep }}</p>
                    <p><strong>{{ __('Cidade: ') }}</strong> {{ $adoptionForm->city }}, {{ $adoptionForm->state }}
                    </p>
                </div>
            </div>


            <!-- Informações da Casa -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden p-6 space-y-4">
                <h3 class="font-semibold text-xl text-blue-800 mb-4">{{ __('🏡 Informações da Casa') }}</h3>
                <div class="grid grid-cols-2 gap-4">
                    <p><strong>{{ __('Tipo de Residência:') }}</strong> {{ $adoptionForm->translated_residence_type }}
                    </p>
                    <p><strong>{{ __('Propriedade da Residência:') }}</strong>
                        {{ $adoptionForm->translated_residence_ownership }}</p>
                    <p><strong>{{ __('Espaço Externo:') }}</strong> {{ $adoptionForm->outdoor_space ? 'Sim' : 'Não' }}
                    </p>
                    <p><strong>{{ __('Medidas de Segurança (cercas, portões, etc.):') }}</strong>
                        {{ $adoptionForm->safety_measures ? 'Sim' : 'Não' }}</p>
                    <p><strong>{{ __('Número de Moradores:') }}</strong> {{ $adoptionForm->number_of_residents }}</p>
                    <p><strong>{{ __('Possui Crianças:') }}</strong> {{ $adoptionForm->has_children ? 'Sim' : 'Não' }}
                    </p>
                    @if ($adoptionForm->has_children)
                        <p><strong>{{ __('Detalhes das Crianças:') }}</strong> {{ $adoptionForm->children_details }}
                        </p>
                    @endif
                    <p><strong>{{ __('Possui Outros Pets:') }}</strong>
                        {{ $adoptionForm->has_other_pets ? 'Sim' : 'Não' }}</p>
                    @if ($adoptionForm->has_other_pets)
                        <p><strong>{{ __('Detalhes dos Outros Pets:') }}</strong>
                            {{ $adoptionForm->other_pets_details }}</p>
                    @endif
                </div>
            </div>

            <!-- Motivação e Expectativas -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden p-6 space-y-4">
                <h3 class="font-semibold text-xl text-blue-800 mb-4">{{ __('🌟 Motivação e Expectativas') }}</h3>
                <p><strong>{{ __('Por que deseja adotar este pet?') }}</strong> {{ $adoptionForm->adoption_reason }}
                </p>
                <p><strong>{{ __('Expectativas para adoção:') }}</strong> {{ $adoptionForm->adoption_expectations }}
                </p>
            </div>

            <!-- Status do Formulário -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden p-6 space-y-4">
                <h3 class="font-semibold text-xl text-blue-800 mb-4">{{ __('📋 Status do Formulário') }}</h3>
                <p><strong>{{ __('Status:') }}</strong> {{ $adoptionForm->translated_status }}</p>
                @if ($adoptionForm->status === 'rejected' && $adoptionForm->rejection_reason)
                    <p><strong>{{ __('Motivo da Rejeição:') }}</strong> {{ $adoptionForm->rejection_reason }}</p>
                @endif
            </div>

            <!-- Botões de Ação (apenas se o status for pendente) -->
            @if (
                $adoptionForm->status === 'pending' &&
                    $adoptionForm->pet &&
                    $adoptionForm->submitter &&
                    Auth::id() === $adoptionForm->pet->user_id)
                <div class="bg-white shadow-md rounded-lg overflow-hidden p-6 space-y-4">
                    <h3 class="font-semibold text-xl text-blue-800">{{ __('Ações Disponíveis') }}</h3>

                    <!-- Botão de Aprovar -->
                    <form
                        action="{{ route('adoption-form.update-status', ['adoptionForm' => $adoptionForm->id, 'status' => 'approved']) }}"
                        method="POST" onsubmit="return confirm('Tem certeza que deseja aprovar esta adoção?')">
                        @csrf
                        @method('PUT')
                        <x-button type="submit"
                            class="bg-green-500 hover:bg-green-600 w-full flex justify-center items-center">
                            {{ __('Aprovar Adoção') }}
                        </x-button>
                    </form>

                    <!-- Botão de Rejeitar -->
                    <x-button type="button" id="rejectButton"
                        class="bg-red-500 hover:bg-red-600 w-full flex justify-center items-center">
                        {{ __('Rejeitar Adoção') }}
                    </x-button>

                    <!-- Campo para Motivo da Rejeição (inicialmente escondido) -->
                    <form id="rejectionForm"
                        action="{{ route('adoption-form.update-status', ['adoptionForm' => $adoptionForm->id, 'status' => 'rejected']) }}"
                        method="POST" style="display: none;" class="flex flex-col space-y-2 mt-4">
                        @csrf
                        @method('PUT')
                        <label for="rejection_reason"
                            class="block text-sm font-medium text-gray-700">{{ __('Motivo da Rejeição') }}</label>
                        <textarea id="rejection_reason" name="rejection_reason" rows="4"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                        <x-button type="submit"
                            class="bg-red-500 hover:bg-red-600 w-full flex justify-center items-center">
                            {{ __('Confirmar Rejeição') }}
                        </x-button>
                    </form>


                </div>
            @endif





        </div>
    </div>

    <!-- Script para mostrar/ocultar o campo de motivo da rejeição -->
    <script>
        document.getElementById('rejectButton').addEventListener('click', function() {
            const rejectionForm = document.getElementById('rejectionForm');
            if (rejectionForm.style.display === 'none') {
                rejectionForm.style.display = 'block';
            } else {
                rejectionForm.style.display = 'none';
            }
        });
    </script>

    <!-- Script para ativar/desativar botão e exibir diálogos de confirmação -->
    <script>
        // Habilitar ou desabilitar o botão de rejeição com base na entrada do motivo
        const rejectionReasonField = document.getElementById('rejection_reason');
        if (rejectionReasonField) {
            rejectionReasonField.addEventListener('input', function() {
                const rejectButton = document.getElementById('rejectButton');
                if (rejectButton) {
                    rejectButton.disabled = this.value.trim() === '';
                }
            });
        }
    </script>
</x-app-layout>
