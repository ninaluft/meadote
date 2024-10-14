<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gerenciar Eventos') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form method="GET" action="{{ route('admin.manage-events') }}" class="mb-4 flex space-x-4">

                    <input type="text" name="search" placeholder="Buscar por nome do evento ou responsável (ONG)"
                        value="{{ request('search') }}"
                        class="flex-grow p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">

                    <!-- Filtro de Eventos -->
                    <select name="event_filter" class="p-2 border w-1/4 border-gray-300 rounded-md">
                        <option value="all" {{ request('event_filter') === 'all' ? 'selected' : '' }}>
                            Todos Eventos ({{ $futureEventsCount + $pastEventsCount }})
                        </option>
                        <option value="future" {{ request('event_filter') === 'future' ? 'selected' : '' }}>
                            Eventos Futuros ({{ $futureEventsCount }})
                        </option>
                        <option value="past" {{ request('event_filter') === 'past' ? 'selected' : '' }}>
                            Eventos Passados ({{ $pastEventsCount }})
                        </option>
                    </select>

                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md">
                        Buscar
                    </button>
                </form>

                @if ($events->count())
                    <!-- Tornando a tabela rolável em dispositivos menores -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <!-- Coluna de ID com Ordenação -->
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a
                                            href="{{ route('admin.manage-events', ['sort_by' => 'id', 'sort_direction' => $sortBy === 'id' && $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => request('search'), 'event_filter' => request('event_filter')]) }}">
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

                                    <!-- Nome do Evento com Ordenação -->
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a
                                            href="{{ route('admin.manage-events', ['sort_by' => 'title', 'sort_direction' => $sortBy === 'title' && $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => request('search'), 'event_filter' => request('event_filter')]) }}">
                                            Nome do Evento
                                            @if ($sortBy === 'title')
                                                @if ($sortDirection === 'asc')
                                                    ▲
                                                @else
                                                    ▼
                                                @endif
                                            @endif
                                        </a>
                                    </th>

                                    <!-- Data do Evento com Ordenação -->
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a
                                            href="{{ route('admin.manage-events', ['sort_by' => 'event_date', 'sort_direction' => $sortBy === 'event_date' && $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => request('search'), 'event_filter' => request('event_filter')]) }}">
                                            Data
                                            @if ($sortBy === 'event_date')
                                                @if ($sortDirection === 'asc')
                                                    ▲
                                                @else
                                                    ▼
                                                @endif
                                            @endif
                                        </a>
                                    </th>

                                    <!-- Nome da ONG (Responsável) com Ordenação -->
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <a
                                            href="{{ route('admin.manage-events', ['sort_by' => 'ong_name', 'sort_direction' => $sortBy === 'ong_name' && $sortDirection === 'asc' ? 'desc' : 'asc', 'search' => request('search'), 'event_filter' => request('event_filter')]) }}">
                                            Responsável (ONG)
                                            @if ($sortBy === 'ong_name')
                                                @if ($sortDirection === 'asc')
                                                    ▲
                                                @else
                                                    ▼
                                                @endif
                                            @endif
                                        </a>
                                    </th>

                                    <th
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($events as $event)
                                    <tr class="hover:bg-gray-100"> <!-- Efeito de darkening ao passar o mouse -->
                                        <!-- Coluna de ID -->
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $event->id }}</td>

                                        <!-- Nome do Evento como link -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('ong-events.show', $event->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900">
                                                {{ $event->title }}
                                            </a>
                                        </td>

                                        <!-- Data do Evento -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}</td>

                                        <!-- Nome da ONG (Responsável) -->
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $event->ong->ong_name }}</td>

                                        <!-- Ações -->
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('admin.delete-event', $event->id) }}" method="POST"
                                                class="inline-block"
                                                onsubmit="return confirm('Você tem certeza que deseja excluir este evento?');">
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
                @else
                    <p>Nenhum evento encontrado.</p>
                @endif

                <!-- Paginação -->
                <div class="mt-4">
                    {{ $events->appends(['sort_by' => $sortBy, 'sort_direction' => $sortDirection, 'search' => request('search'), 'event_filter' => request('event_filter')])->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
