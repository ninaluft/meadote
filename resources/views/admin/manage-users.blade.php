<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gerenciar Usuários') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <!-- Formulário de Pesquisa -->
                <form method="GET" action="{{ route('admin.manage-users') }}" class="mb-4 flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <!-- Campo de busca ocupa mais espaço e é responsivo -->
                    <input type="text" name="search" placeholder="Buscar por nome ou email"
                           value="{{ request('search') }}"
                           class="w-full sm:flex-grow p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

                    <!-- Filtro por tipo de usuário, adaptado para responsividade -->
                    <select name="user_type" class="w-full sm:w-1/4 p-2 border border-gray-300 rounded-md">
                        <option value="">Todos Usuários ({{ array_sum($userTypeCounts) }})</option>
                        <option value="tutor" {{ request('user_type') === 'tutor' ? 'selected' : '' }}>
                            Tutor ({{ $userTypeCounts['tutor'] ?? 0 }})
                        </option>
                        <option value="ong" {{ request('user_type') === 'ong' ? 'selected' : '' }}>
                            ONG ({{ $userTypeCounts['ong'] ?? 0 }})
                        </option>
                        <option value="admin" {{ request('user_type') === 'admin' ? 'selected' : '' }}>
                            Administrador ({{ $userTypeCounts['admin'] ?? 0 }})
                        </option>
                    </select>

                    <!-- Botão de Buscar com tamanho fixo, adaptado para responsividade -->
                    <button type="submit"
                            class="w-full sm:w-auto bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md">
                        Buscar
                    </button>
                </form>


                @if ($users->count() > 0)
                    <!-- Tabela Responsiva -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <!-- Sorting por ID -->
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('admin.manage-users', ['sort_by' => 'id', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search'), 'user_type' => request('user_type')]) }}"
                                            class="hover:text-indigo-600">
                                            ID @if (request('sort_by') == 'id')
                                                @if (request('sort_direction') == 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            @endif
                                        </a>
                                    </th>

                                    <!-- Sorting por Nome -->
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('admin.manage-users', ['sort_by' => 'name', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search'), 'user_type' => request('user_type')]) }}"
                                            class="hover:text-indigo-600">
                                            Nome @if (request('sort_by') == 'name')
                                                @if (request('sort_direction') == 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            @endif
                                        </a>
                                    </th>

                                    <!-- Sorting por Email -->
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('admin.manage-users', ['sort_by' => 'email', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search'), 'user_type' => request('user_type')]) }}"
                                            class="hover:text-indigo-600">
                                            Email @if (request('sort_by') == 'email')
                                                @if (request('sort_direction') == 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            @endif
                                        </a>
                                    </th>

                                    <!-- Sorting por Tipo de Usuário -->
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a href="{{ route('admin.manage-users', ['sort_by' => 'user_type', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search'), 'user_type' => request('user_type')]) }}"
                                            class="hover:text-indigo-600">
                                            Tipo de Usuário @if (request('sort_by') == 'user_type')
                                                @if (request('sort_direction') == 'asc')
                                                    &uarr;
                                                @else
                                                    &darr;
                                                @endif
                                            @endif
                                        </a>
                                    </th>

                                    <!-- Coluna de Ações -->
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($users as $user)
                                    <tr class="hover:bg-gray-100">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->id }}</td>

                                        <!-- Nome do usuário, clicável para abrir a página de detalhes -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('admin.user-details', $user->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900">{{ $user->name }}</a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>

                                        <!-- Dropdown de user_type com formulário -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form method="POST" action="{{ route('admin.update-user', $user->id) }}" id="user-type-form-{{ $user->id }}">
                                                @csrf
                                                <select name="usertype"
                                                        onchange="confirmUserTypeChange(this, '{{ $user->name }}', {{ $user->id }})"
                                                        class="block w-full p-2 border border-gray-300 rounded-md">
                                                    <option value="tutor" {{ $user->user_type == 'tutor' ? 'selected' : '' }}>Tutor</option>
                                                    <option value="ong" {{ $user->user_type == 'ong' ? 'selected' : '' }}>ONG</option>
                                                    <option value="admin" {{ $user->user_type == 'admin' ? 'selected' : '' }}>Administrador</option>
                                                </select>
                                            </form>
                                        </td>

                                        <!-- Botão de Deletar -->
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('admin.delete-user', $user->id) }}" method="POST"
                                                onsubmit="return confirm('Tem certeza que deseja deletar este usuário?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded-lg">
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
                        {{ $users->appends(request()->input())->links() }}
                    </div>
                @else
                    <p>Nenhum usuário encontrado.</p>
                @endif

            </div>
        </div>
    </div>

    <script>
        function confirmUserTypeChange(selectElement, userName, userId) {
            const userType = selectElement.value;
            const confirmation = confirm(`Tem certeza que deseja alterar o tipo de usuário de ${userName} para ${userType}?`);

            if (confirmation) {
                document.getElementById(`user-type-form-${userId}`).submit();
            } else {
                // Reverte a seleção para o valor anterior se o usuário cancelar
                selectElement.selectedIndex = Array.from(selectElement.options).findIndex(
                    option => option.value === '{{ $user->user_type }}'
                );
            }
        }
    </script>
</x-app-layout>
