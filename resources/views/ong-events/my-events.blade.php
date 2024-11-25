<!-- resources/views/ong-events/my-events.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Meus Eventos') }}
            </h2>

            <!-- Botão Adicionar Novo Evento -->
            <x-button href="{{ route('events.create') }}" class="bg-green-500 text-white font-bold px-2 py-2 rounded hover:bg-green-600">
                {{ __('Novo Evento') }}
            </x-button>

        </div>
    </x-slot>


    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">


                <!-- Eventos Futuros -->
                <h3 class="text-lg font-semibold mb-4">{{ __('Eventos Futuros') }}</h3>
                @if($futureEvents->isEmpty())
                    <p>{{ __('Você não tem eventos futuros.') }}</p>
                @else
                    <ul class="space-y-4">
                        @foreach($futureEvents as $event)
                            <li class="border rounded-lg p-4 bg-white shadow">
                                <h4 class="font-bold text-lg">{{ $event->title }}</h4>
                                <p><strong>{{ __('Data:') }}</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}</p>
                                <p><strong>{{ __('Local:') }}</strong> {{ $event->location }}</p>

                                <div class="mt-2">
                                    <a href="{{ route('ong-events.show', $event->id) }}" class="text-indigo-600 hover:underline">
                                        {{ __('Ver Detalhes') }}
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <!-- Eventos Passados -->
                <h3 class="text-lg font-semibold mb-6 mt-10">{{ __('Eventos Passados') }}</h3>
                @if($pastEvents->isEmpty())
                    <p>{{ __('Você não tem eventos passados.') }}</p>
                @else
                    <ul class="space-y-4">
                        @foreach($pastEvents as $event)
                            <li class="border rounded-lg p-4 bg-white shadow">
                                <h4 class="font-bold text-lg">{{ $event->title }}</h4>
                                <p><strong>{{ __('Data:') }}</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('d/m/Y') }}</p>
                                <p><strong>{{ __('Local:') }}</strong> {{ $event->location }}</p>

                                <div class="mt-2">
                                    <a href="{{ route('ong-events.show', $event->id) }}" class="text-indigo-600 hover:underline">
                                        {{ __('Ver Detalhes') }}
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
