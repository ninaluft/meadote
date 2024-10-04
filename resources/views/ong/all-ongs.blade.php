<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Todas as ONGs') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Formulário de busca -->
                <form action="{{ route('ongs.index') }}" method="GET" class="mb-6">
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <x-input id="ong_name" name="ong_name" value="{{ request('ong_name') }}" placeholder="Nome da ONG" class="w-full" />
                        <x-input id="city" name="city" value="{{ request('city') }}" placeholder="Cidade" class="w-full" />
                        <x-button class="w-full sm:w-auto">{{ __('Buscar') }}</x-button>
                    </div>
                </form>

                @if ($ongs->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($ongs as $ong)
                            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                                <a href="{{ route('user.public-profile', $ong->user->id) }}">
                                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                                        @if (!empty($ong->user->profile_photo_path))
                                            <img src="{{ asset('storage/' . $ong->user->profile_photo_path) }}" alt="{{ $ong->ong_name }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="flex items-center justify-center h-full w-full bg-gray-400">
                                                <span class="text-4xl font-bold text-white">
                                                    {{ strtoupper(substr($ong->ong_name, 0, 1)) }}{{ strtoupper(substr($ong->ong_name, 1, 1)) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </a>

                                <div class="p-4">
                                    <h2 class="text-lg font-bold mb-2">
                                        <a href="{{ route('user.public-profile', $ong->user->id) }}" class="text-blue-600 hover:underline">
                                            {{ $ong->ong_name }}
                                        </a>
                                    </h2>
                                    <p class="text-gray-700">{{ Str::limit($ong->about_ong, 100) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Links de Paginação -->
                    <div class="mt-6">
                        {{ $ongs->links() }}
                    </div>
                @else
                    <p class="text-center text-gray-600">{{ __('Nenhuma ONG encontrada.') }}</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
