<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulário de Adoção para ') . $adoptionForm->pet_name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 space-y-6">
                <!-- Informações do Pet -->
                <div class="border-b pb-4">
                    <h3 class="font-semibold text-lg mb-4">{{ __('Informações do Pet') }}</h3>
                    <p><strong>{{ __('Nome do Pet:') }}</strong> {{ $adoptionForm->pet_name }}</p>
                    <p><strong>{{ __('Espécie:') }}</strong> {{ __('pets.species_list.' . $adoptionForm->species) }}</p>
                    <p><strong>{{ __('Cadastrado por:') }}</strong> {{ $adoptionForm->responsible_user_name }}</p>
                </div>

                <!-- Informações do Solicitante -->
                <div class="border-b pb-4">
                    <h3 class="font-semibold text-lg mb-4">{{ __('Informações do Solicitante') }}</h3>
                    <p><strong>{{ __('Nome Completo:') }}</strong> {{ $adoptionForm->submitter_name }}</p>
                    <p><strong>{{ __('CPF:') }}</strong> {{ $adoptionForm->cpf }}</p>
                    <p><strong>{{ __('Data de Nascimento:') }}</strong> {{ $adoptionForm->birth_date }}</p>
                    <p><strong>{{ __('Telefone:') }}</strong> {{ $adoptionForm->phone }}</p>
                    <p><strong>{{ __('Email:') }}</strong> {{ $adoptionForm->email }}</p>
                    <p><strong>{{ __('Estado Civil:') }}</strong> {{ $adoptionForm->marital_status }}</p>
                    <p><strong>{{ __('Profissão:') }}</strong> {{ $adoptionForm->profession }}</p>
                </div>

                <!-- Informações do Endereço -->
                <div class="border-b pb-4">
                    <h3 class="font-semibold text-lg mb-4">{{ __('Informações do Endereço') }}</h3>
                    <p><strong>{{ __('CEP:') }}</strong> {{ $adoptionForm->cep }}</p>
                    <p><strong>{{ __('Cidade:') }}</strong> {{ $adoptionForm->city }}</p>
                    <p><strong>{{ __('Estado:') }}</strong> {{ $adoptionForm->state }}</p>
                    <p><strong>{{ __('Rua:') }}</strong> {{ $adoptionForm->street }}</p>
                    <p><strong>{{ __('Número:') }}</strong> {{ $adoptionForm->number }}</p>
                    <p><strong>{{ __('Complemento:') }}</strong> {{ $adoptionForm->complement ?? 'N/A' }}</p>
                    <p><strong>{{ __('Bairro:') }}</strong> {{ $adoptionForm->neighborhood }}</p>
                </div>

                <!-- Informações da Casa -->
                <div class="border-b pb-4">
                    <h3 class="font-semibold text-lg mb-4">{{ __('Informações da Casa') }}</h3>
                    <p><strong>{{ __('Tipo de Residência:') }}</strong> {{ ucfirst($adoptionForm->residence_type) }}
                    </p>
                    <p><strong>{{ __('Propriedade da Residência:') }}</strong>
                        {{ ucfirst($adoptionForm->residence_ownership) }}</p>
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

                <!-- Motivação e Expectativas -->
                <div class="border-b pb-4">
                    <h3 class="font-semibold text-lg mb-4">{{ __('Motivação e Expectativas') }}</h3>
                    <p><strong>{{ __('Por que deseja adotar este pet?') }}</strong>
                        {{ $adoptionForm->adoption_reason }}</p>
                    <p><strong>{{ __('Expectativas para adoção:') }}</strong>
                        {{ $adoptionForm->adoption_expectations }}</p>
                </div>

                <!-- Status -->
                <div class="pb-4">
                    <h3 class="font-semibold text-lg mb-4">{{ __('Status do Formulário') }}</h3>
                    <p><strong>{{ __('Status:') }}</strong> {{ ucfirst($adoptionForm->status) }}</p>

                    <!-- Motivo da Rejeição (se rejeitado) -->
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
                    <div class="flex flex-col space-y-4 mt-6 p-4 border rounded-lg bg-gray-50">
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

                        <!-- Botão de Rejeitar e Campo para Motivo -->
                        <form
                            action="{{ route('adoption-form.update-status', ['adoptionForm' => $adoptionForm->id, 'status' => 'rejected']) }}"
                            method="POST" onsubmit="return confirm('Tem certeza que deseja rejeitar esta adoção?')"
                            class="flex flex-col space-y-2">
                            @csrf
                            @method('PUT')
                            <div class="mb-2">
                                <label for="rejection_reason"
                                    class="block text-sm font-medium text-gray-700">{{ __('Motivo da Rejeição') }}</label>
                                <textarea id="rejection_reason" name="rejection_reason" rows="4"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                            </div>
                            <x-button type="submit"
                                class="bg-red-500 hover:bg-red-600 w-full flex justify-center items-center">
                                {{ __('Rejeitar Adoção') }}
                            </x-button>
                        </form>

                        <!-- Botão de Enviar Mensagem para o Solicitante -->
                        <form
                            action="{{ route('messages.conversation', ['user' => $adoptionForm->submitter_user_id]) }}"
                            method="GET">
                            <x-button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 w-full flex justify-center items-center">
                                {{ __('Enviar Mensagem ao Solicitante') }}
                            </x-button>
                        </form>
                    </div>
                @elseif(!$adoptionForm->pet || !$adoptionForm->submitter)
                    <div>
                        <h2 class="font-bold text-red-500">Esse usuário ou pet não existem mais na plataforma.</h2>
                    </div>
                @endif


            </div>
        </div>
    </div>
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
