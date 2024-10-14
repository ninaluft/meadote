<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel do Administrador - Solicitações de Suporte') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="font-semibold text-lg mb-4">Todas as Solicitações de Suporte</h3>

                    @if($supportRequests->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuário</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assunto</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('admin.support.index', ['sort' => 'status', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="hover:underline">
                                                Status
                                                @if(request('sort') == 'status')
                                                    @if(request('direction') == 'asc')
                                                        ▲
                                                    @else
                                                        ▼
                                                    @endif
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('admin.support.index', ['sort' => 'created_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}" class="hover:underline">
                                                Data de Criação
                                                @if(request('sort') == 'created_at')
                                                    @if(request('direction') == 'asc')
                                                        ▲
                                                    @else
                                                        ▼
                                                    @endif
                                                @endif
                                            </a>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($supportRequests as $supportRequest)
                                        <tr class="hover:bg-gray-100 transition">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $supportRequest->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $supportRequest->user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $supportRequest->subject }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    {{ $supportRequest->status == 'open' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ ucfirst($supportRequest->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $supportRequest->created_at->format('Y-m-d') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                <a href="{{ route('admin.support.show', $supportRequest->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 transition ease-in-out duration-150">
                                                    Ver
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginação (se aplicável) -->
                        <div class="mt-6">
                            {{ $supportRequests->appends(request()->input())->links() }}
                        </div>
                    @else
                        <p class="text-gray-500 mt-6">Nenhuma solicitação de suporte encontrada.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
