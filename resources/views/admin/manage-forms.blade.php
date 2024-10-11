<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Gerenciar Formulários de Adoção') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form method="GET" action="{{ route('admin.manage-forms') }}" id="filterForm"
                    class="mb-4 grid grid-cols-1 sm:grid-cols-3 gap-4">

                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Digite o nome do pet ou enviador"
                        class="p-2 border border-gray-300 rounded-md w-full">

                    <select name="form_status" id="form_status" class="p-2 border border-gray-300 rounded-md w-full"
                        onchange="document.getElementById('filterForm').submit();">
                        <option value="">Todos ({{ array_sum($statusCounts) }})</option>
                        <option value="approved" {{ request('form_status') === 'approved' ? 'selected' : '' }}>
                            Aceito ({{ $statusCounts['approved'] ?? 0 }})
                        </option>
                        <option value="rejected" {{ request('form_status') === 'rejected' ? 'selected' : '' }}>
                            Rejeitado ({{ $statusCounts['rejected'] ?? 0 }})
                        </option>
                        <option value="pending" {{ request('form_status') === 'pending' ? 'selected' : '' }}>
                            Pendente ({{ $statusCounts['pending'] ?? 0 }})
                        </option>
                    </select>

                    <div class="flex-none">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md w-full">Buscar</button>
                    </div>
                </form>
            </div>

            @if ($forms->isEmpty())
                <p class="text-gray-500">Nenhum formulário encontrado.</p>
            @else
                <!-- Adicionando a responsividade à tabela -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('admin.manage-forms', ['sort_by' => 'id', 'sort_direction' => $sortBy === 'id' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}"
                                        class="hover:text-indigo-600">
                                        ID
                                        @if ($sortBy === 'id')
                                            @if ($sortDirection === 'asc')
                                                ▲
                                            @else
                                                ▼
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('admin.manage-forms', ['sort_by' => 'pet_id', 'sort_direction' => $sortBy === 'pet_id' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}"
                                        class="hover:text-indigo-600">
                                        Nome do Pet
                                        @if ($sortBy === 'pet_id')
                                            @if ($sortDirection === 'asc')
                                                ▲
                                            @else
                                                ▼
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('admin.manage-forms', ['sort_by' => 'submitter_id', 'sort_direction' => $sortBy === 'submitter_id' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}"
                                        class="hover:text-indigo-600">
                                        Nome do Enviador
                                        @if ($sortBy === 'submitter_id')
                                            @if ($sortDirection === 'asc')
                                                ▲
                                            @else
                                                ▼
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('admin.manage-forms', ['sort_by' => 'status', 'sort_direction' => $sortBy === 'status' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}"
                                        class="hover:text-indigo-600">
                                        Status
                                        @if ($sortBy === 'status')
                                            @if ($sortDirection === 'asc')
                                                ▲
                                            @else
                                                ▼
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($forms as $form)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $form->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $form->pet ? $form->pet->name : 'Pet não encontrado' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $form->submitter ? $form->submitter->name : 'Usuário não encontrado' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @switch($form->status)
                                            @case('approved')
                                                <span class="text-green-600 font-bold">{{ __('Aceito') }}</span>
                                            @break

                                            @case('rejected')
                                                <span class="text-red-600 font-bold">{{ __('Rejeitado') }}</span>
                                            @break

                                            @case('cancelled')
                                                <span class="text-yellow-600 font-bold">{{ __('Cancelado') }}</span>
                                            @break

                                            @default
                                                <span class="text-gray-600 font-bold">{{ __('Pendente') }}</span>
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button type="submit"
                                            class="bg-indigo-600 hover:bg-indigo-700 text-white py-1 px-3 rounded-lg">
                                            <a href="{{ route('adoption-form.show', $form->id) }}"
                                                class="hover:text-white">Visualizar</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <div class="mt-4">
                    {{ $forms->appends(request()->input())->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
