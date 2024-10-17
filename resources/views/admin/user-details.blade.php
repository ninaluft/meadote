<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <!-- Nome do usuário como link para o perfil público -->
            {{ __('Detalhes do Usuário: ') }}
            <a href="{{ route('user.public-profile', $user->id) }}" class="text-blue-600 hover:text-blue-800">
                {{ $user->name }}
            </a>
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-10">

                <!-- Informações Básicas do Usuário -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold mb-4">Informações Básicas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <p><strong>ID:</strong> {{ $user->id }}</p>
                        <p><strong>Nome:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Tipo de Usuário:</strong> {{ ucfirst($user->user_type) }}</p>
                        <p><strong>Cidade:</strong> {{ $user->city ?? 'Não Informado' }}</p>
                        <p><strong>Estado:</strong> {{ $user->state ?? 'Não Informado' }}</p>
                        <p><strong>CEP:</strong> {{ $user->cep ?? 'Não Informado' }}</p>
                    </div>
                </div>

                <!-- Exibir informações específicas com base no tipo de usuário -->
                @if ($user->user_type == 'tutor')
                    <!-- Informações do Tutor -->
                    <div class="border-b pb-6">
                        <h3 class="text-lg font-semibold mb-4">Informações do Tutor</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <p><strong>Nome Completo:</strong> {{ $user->tutor->full_name }}</p>
                            <p><strong>Data de Nascimento:</strong> {{ \Carbon\Carbon::parse($user->tutor->date_of_birth)->format('d/m/Y') }}</p>
                            <p><strong>CPF:</strong> {{ $user->tutor->cpf }}</p>
                            <p><strong>Lar Temporário Disponível:</strong> {{ $user->tutor->temporary_housing ? 'Sim' : 'Não' }}</p>
                            <p><strong>Sobre o Tutor:</strong> {{ $user->tutor->about_me ?? 'Não informado' }}</p>
                        </div>
                    </div>
                @elseif ($user->user_type == 'ong')
                    <!-- Informações da ONG -->
                    <div class="border-b pb-6">
                        <h3 class="text-lg font-semibold mb-4">Informações da ONG</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <p><strong>Nome da ONG:</strong> {{ $user->ong->ong_name }}</p>
                            <p><strong>Telefone:</strong> {{ $user->ong->phone }}</p>
                            <p><strong>Nome do Responsável:</strong> {{ $user->ong->responsible_name }}</p>
                            <p><strong>CPF do Responsável:</strong> {{ $user->ong->responsible_cpf }}</p>
                            <p><strong>CNPJ:</strong> {{ $user->ong->cnpj }}</p>
                            <p><strong>Sobre a ONG:</strong> {{ $user->ong->about_ong ?? 'Não informado' }}</p>
                        </div>
                    </div>
                @endif

                <!-- Estatísticas do Usuário -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold mb-4">Estatísticas do Usuário</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <p><strong>Total de Animais Cadastrados:</strong> {{ $totalPets }}</p>
                        <p><strong>Total de Animais Adotados:</strong> {{ $totalAdoptedPets }}</p>
                        <p><strong>Total de Eventos Cadastrados:</strong> {{ $totalEvents }}</p>
                        <p><strong>Total de Formulários Enviados:</strong> {{ $totalFormsSent }}</p>
                        <p><strong>Total de Formulários Recebidos:</strong> {{ $totalFormsReceived }}</p>
                    </div>
                </div>

                <!-- Lista de Pets (com barra de rolagem) -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold mb-4">Animais Cadastrados ({{ $user->pets->count() }})</h3>
                    <div class="overflow-y-auto max-h-64">
                        @if ($user->pets->count() > 0)
                            <table class="min-w-full bg-white divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($user->pets as $pet)
                                        <tr>
                                            <td class="px-6 py-4">{{ $pet->name }}</td>
                                            <td class="px-6 py-4">{{ __('pets.status_list.' . $pet->status) }}</td>
                                            <td class="px-6 py-4 text-right">
                                                <a href="{{ route('pets.show', $pet->id) }}" class="text-indigo-600 hover:text-indigo-900">Ver Perfil</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>Nenhum animal cadastrado.</p>
                        @endif
                    </div>
                </div>

                <!-- Lista de Eventos (com barra de rolagem) -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold mb-4">Eventos Cadastrados ({{ $user->ongEvents->count() }})</h3>
                    <div class="overflow-y-auto max-h-64">
                        @if ($user->ongEvents->count() > 0)
                            <table class="min-w-full bg-white divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($user->ongEvents as $event)
                                        <tr>
                                            <td class="px-6 py-4">{{ $event->title }}</td>
                                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}</td>
                                            <td class="px-6 py-4 text-right">
                                                <a href="{{ route('ong-events.show', $event->id) }}" class="text-indigo-600 hover:text-indigo-900">Ver Detalhes</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>Nenhum evento cadastrado.</p>
                        @endif
                    </div>
                </div>

                <!-- Lista de Formulários Enviados (com barra de rolagem) -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold mb-4">Formulários Enviados ({{ $user->adoptionFormsSent->count() }})</h3>
                    <div class="overflow-y-auto max-h-64">
                        @if ($user->adoptionFormsSent->count() > 0)
                            <table class="min-w-full bg-white divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pet</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($user->adoptionFormsSent as $form)
                                        @if ($form->pet)
                                            <tr>
                                                <td class="px-6 py-4">{{ $form->pet->name }}</td>
                                                <td class="px-6 py-4">{{ ucfirst($form->status) }}</td>
                                                <td class="px-6 py-4 text-right">
                                                    <a href="{{ route('pets.show', $form->pet->id) }}" class="text-indigo-600 hover:text-indigo-900">Ver Perfil do Pet</a>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td class="px-6 py-4 text-red-500" colspan="3">Pet não encontrado</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>Nenhum formulário enviado.</p>
                        @endif
                    </div>
                </div>

                <!-- Lista de Formulários Recebidos (com barra de rolagem) -->
                <div class="pb-6">
                    <h3 class="text-lg font-semibold mb-4">Formulários Recebidos ({{ $user->adoptionFormsReceived->count() }})</h3>
                    <div class="overflow-y-auto max-h-64">
                        @if ($user->adoptionFormsReceived->count() > 0)
                            <table class="min-w-full bg-white divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">De</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pet</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($user->adoptionFormsReceived as $form)
                                        @if ($form->pet)
                                            <tr>
                                                <td class="px-6 py-4">{{ $form->submitter_name }}</td>
                                                <td class="px-6 py-4">{{ $form->pet->name }}</td>
                                                <td class="px-6 py-4">{{ ucfirst($form->status) }}</td>
                                                <td class="px-6 py-4 text-right">
                                                    <a href="{{ route('pets.show', $form->pet->id) }}" class="text-indigo-600 hover:text-indigo-900">Ver Perfil do Pet</a>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td class="px-6 py-4 text-red-500" colspan="4">Pet não encontrado</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>Nenhum formulário recebido.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
