<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gerenciar Pets') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <!-- Formulário de Pesquisa -->
                <form method="GET" action="{{ route('admin.manage-pets') }}" class="mb-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Campo de busca -->
                    <input type="text" name="search" placeholder="Buscar por nome do pet ou responsável"
                        value="{{ request('search') }}"
                        class="p-2 border border-gray-300 rounded-md w-full">

                    <!-- Filtro de Status -->
                    <select name="status" class="p-2 border border-gray-300 rounded-md w-full">
                        <option value="">Todos os Status ({{ array_sum($statusCounts) }})</option>
                        <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>
                            Disponível ({{ $statusCounts['available'] ?? 0 }})
                        </option>
                        <option value="adopted" {{ request('status') === 'adopted' ? 'selected' : '' }}>
                            Adotado ({{ $statusCounts['adopted'] ?? 0 }})
                        </option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>
                            Pendente ({{ $statusCounts['pending'] ?? 0 }})
                        </option>
                    </select>

                    <!-- Botão de Busca -->
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md w-full sm:w-auto">
                        Buscar
                    </button>
                </form>

                @if ($pets->count() > 0)
                    <!-- Adicionando responsividade à tabela -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <!-- Sorting por ID -->
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('admin.manage-pets', ['sort_by' => 'id', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search'), 'status' => request('status')]) }}">
                                            ID
                                            @if (request('sort_by') == 'id')
                                                @if (request('sort_direction') == 'asc')
                                                    ▲
                                                @else
                                                    ▼
                                                @endif
                                            @endif
                                        </a>
                                    </th>

                                    <!-- Sorting por Nome -->
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('admin.manage-pets', ['sort_by' => 'name', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search'), 'status' => request('status')]) }}">
                                            Nome
                                            @if (request('sort_by') == 'name')
                                                @if (request('sort_direction') == 'asc')
                                                    ▲
                                                @else
                                                    ▼
                                                @endif
                                            @endif
                                        </a>
                                    </th>

                                    <!-- Sorting por Espécie -->
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('admin.manage-pets', ['sort_by' => 'species', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search'), 'status' => request('status')]) }}">
                                            Espécie
                                            @if (request('sort_by') == 'species')
                                                @if (request('sort_direction') == 'asc')
                                                    ▲
                                                @else
                                                    ▼
                                                @endif
                                            @endif
                                        </a>
                                    </th>

                                    <!-- Sorting por Status -->
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('admin.manage-pets', ['sort_by' => 'status', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search'), 'status' => request('status')]) }}">
                                            Status
                                            @if (request('sort_by') == 'status')
                                                @if (request('sort_direction') == 'asc')
                                                    ▲
                                                @else
                                                    ▼
                                                @endif
                                            @endif
                                        </a>
                                    </th>

                                    <!-- Responsável pelo Cadastro -->
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('admin.manage-pets', ['sort_by' => 'user_id', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search'), 'status' => request('status')]) }}">
                                            Responsável
                                            @if (request('sort_by') == 'user_id')
                                                @if (request('sort_direction') == 'asc')
                                                    ▲
                                                @else
                                                    ▼
                                                @endif
                                            @endif
                                        </a>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($pets as $pet)
                                    <tr>
                                        <!-- ID do pet -->
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pet->id }}</td>
                                        <!-- Nome do pet, clicável para abrir o perfil do pet -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('pets.show', $pet->id) }}" class="text-indigo-600 hover:text-indigo-900">{{ $pet->name }}</a>
                                        </td>
                                        <!-- Tradução da espécie -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ __('pets.species_list.' . $pet->species) }}
                                        </td>
                                        <!-- Tradução do status -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ __('pets.status_list.' . $pet->status) }}
                                        </td>
                                        <!-- Nome do responsável -->
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $pet->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('admin.delete-pet', $pet->id) }}" method="POST" onsubmit="return confirm('Você tem certeza que deseja excluir este pet?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded-lg">
                                                    Deletar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginação -->
                    <div class="mt-4">
                        {{ $pets->appends(request()->input())->links() }}
                    </div>
                @else
                    <p>Nenhum pet encontrado.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
