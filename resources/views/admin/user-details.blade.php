<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalhes do Usuário: ') . $user->name }}
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
                    </div>
                </div>

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

                <!-- Lista de Pets -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold mb-4">Animais Cadastrados</h3>
                    @if ($user->pets->count() > 0)
                        <table class="min-w-full bg-white divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nome</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($user->pets as $pet)
                                    <tr>
                                        <td class="px-6 py-4">{{ $pet->name }}</td>
                                        <td class="px-6 py-4">{{ __('pets.status_list.' . $pet->status) }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('pets.show', $pet->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Ver Perfil</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Nenhum animal cadastrado.</p>
                    @endif
                </div>

                <!-- Lista de Eventos -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold mb-4">Eventos Cadastrados</h3>
                    @if ($user->ongEvents->count() > 0)
                        <table class="min-w-full bg-white divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Título</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Data</th>
                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($user->ongEvents as $event)
                                    <tr>
                                        <td class="px-6 py-4">{{ $event->title }}</td>
                                        <td class="px-6 py-4">
                                            {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('ong-events.show', $event->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Ver Detalhes</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Nenhum evento cadastrado.</p>
                    @endif
                </div>

                <!-- Lista de Formulários Enviados -->
                <h3 class="text-lg font-semibold my-6">Formulários Enviados</h3>
                @if ($user->adoptionFormsSent->count() > 0)
                    <table class="min-w-full bg-white divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pet</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($user->adoptionFormsSent as $form)
                                @if ($form->pet)
                                    <!-- Verifica se o pet ainda está associado -->
                                    <tr>
                                        <td class="px-6 py-4">{{ $form->pet->name }}</td>
                                        <td class="px-6 py-4">{{ ucfirst($form->status) }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('pets.show', $form->pet->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Ver Perfil do Pet</a>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="px-6 py-4" colspan="3" class="text-red-500">Pet não encontrado
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Nenhum formulário enviado.</p>
                @endif

                <!-- Lista de Formulários Recebidos -->
                <h3 class="text-lg font-semibold my-6">Formulários Recebidos</h3>
                @if ($user->adoptionFormsReceived->count() > 0)
                    <table class="min-w-full bg-white divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    De</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Pet</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($user->adoptionFormsReceived as $form)
                                @if ($form->pet)
                                    <!-- Verifica se o pet ainda está associado -->
                                    <tr>
                                        <td class="px-6 py-4">{{ $form->submitter_name }}</td>
                                        <td class="px-6 py-4">{{ $form->pet->name }}</td>
                                        <td class="px-6 py-4">{{ ucfirst($form->status) }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('pets.show', $form->pet->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Ver Perfil do Pet</a>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="px-6 py-4" colspan="4" class="text-red-500">Pet não encontrado
                                        </td>
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
</x-app-layout>
