<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Gerenciar Formulários de Adoção') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Filtro por Status do Formulário -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Filtros de Formulários de Adoção</h3>
                    <form method="GET" action="{{ route('admin.manage-forms') }}" id="filterForm" class="flex flex-col md:flex-row md:items-end md:space-x-4 space-y-4 md:space-y-0">
                        <!-- Filtro por Status do Formulário -->
                        <div class="flex-grow">
                            <label for="form_status" class="block text-sm font-medium text-gray-700">Status do Formulário</label>
                            <select name="form_status" id="form_status" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" onchange="document.getElementById('filterForm').submit();">
                                <option value="">Todos</option>
                                <option value="approved" {{ request('form_status') === 'approved' ? 'selected' : '' }}>Aceito</option>
                                <option value="rejected" {{ request('form_status') === 'rejected' ? 'selected' : '' }}>Rejeitado</option>
                                <option value="cancelled" {{ request('form_status') === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </div>
                    </form>
                </div>

                <!-- Lista de Formulários -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Lista de Formulários de Adoção</h3>
                    @if($forms->isEmpty())
                        <p class="text-gray-500">Nenhum formulário encontrado.</p>
                    @else
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border-b-2">
                                        <a href="{{ route('admin.manage-forms', ['sort_by' => 'id', 'sort_direction' => $sortBy === 'id' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                            ID
                                            @if ($sortBy === 'id')
                                                @if ($sortDirection === 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 border-b-2">
                                        <a href="{{ route('admin.manage-forms', ['sort_by' => 'pet_id', 'sort_direction' => $sortBy === 'pet_id' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                            Nome do Pet
                                            @if ($sortBy === 'pet_id')
                                                @if ($sortDirection === 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 border-b-2">
                                        <a href="{{ route('admin.manage-forms', ['sort_by' => 'submitter_id', 'sort_direction' => $sortBy === 'submitter_id' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                            Nome do Enviador
                                            @if ($sortBy === 'submitter_id')
                                                @if ($sortDirection === 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 border-b-2">
                                        <a href="{{ route('admin.manage-forms', ['sort_by' => 'status', 'sort_direction' => $sortBy === 'status' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
                                            Status
                                            @if ($sortBy === 'status')
                                                @if ($sortDirection === 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-4 py-2 border-b-2">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($forms as $form)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $form->id }}</td>
                                        <td class="border px-4 py-2">{{ $form->pet ? $form->pet->name : 'Pet não encontrado' }}</td>
                                        <td class="border px-4 py-2">{{ $form->submitter ? $form->submitter->name : 'Usuário não encontrado' }}</td>
                                        <td class="border px-4 py-2">
                                            @switch($form->status)
                                                @case('approved')
                                                    <span class="text-green-600 font-bold">Aceito</span>
                                                    @break
                                                @case('rejected')
                                                    <span class="text-red-600 font-bold">Rejeitado</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="text-yellow-600 font-bold">Cancelado</span>
                                                    @break
                                                @default
                                                    <span class="text-gray-600 font-bold">Pendente</span>
                                            @endswitch
                                        </td>
                                        <td class="border px-4 py-2">
                                            <a href="{{ route('adoption-form.show', $form->id) }}" class="text-indigo-600 hover:text-indigo-800 font-semibold underline">Visualizar</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Paginação -->
                        <div class="mt-6">
                            {{ $forms->appends(['sort_by' => $sortBy, 'sort_direction' => $sortDirection, 'form_status' => request('form_status')])->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
