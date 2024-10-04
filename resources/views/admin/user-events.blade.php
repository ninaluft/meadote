<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Eventos Registrados por ') . $user->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                @if($events->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <!-- Coluna de ID -->
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                    @if(request('sort_by') == 'id')
                                        @if(request('sort_direction') == 'asc')
                                            ▲
                                        @else
                                            ▼
                                        @endif
                                    @endif
                                </th>

                                <!-- Coluna de Título -->
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ route('admin.manage-events', ['sort_by' => 'title', 'sort_direction' => request('sort_direction') == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">
                                        Título
                                        @if(request('sort_by') == 'title')
                                            @if(request('sort_direction') == 'asc')
                                                ▲
                                            @else
                                                ▼
                                            @endif
                                        @endif
                                    </a>
                                </th>

                                <!-- Coluna de Data do Evento -->
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Data do Evento
                                </th>

                                <!-- Coluna de Local -->
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Local
                                </th>

                                <!-- Coluna de Ações -->
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($events as $event)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $event->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('ong-events.show', $event->id) }}" class="text-indigo-600 hover:text-indigo-900">{{ $event->title }}</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $event->event_date->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $event->location }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form action="{{ route('ong-events.destroy', $event->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja deletar este evento?');">
                                            @csrf
                                            @method('DELETE')
                                      <button type="submit" class="text-red-600 hover:text-red-900">Deletar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Paginação -->
                    <div class="mt-4">
                        {{ $events->links() }}
                    </div>
                @else
                    <p>Nenhum evento encontrado.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
