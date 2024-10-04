<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Solicitações de Suporte') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Suas Solicitações</h3>

                <ul>
                    @foreach ($supportRequests as $request)
                        <li>
                            <a href="{{ route('support.show', $request) }}" class="text-indigo-600 hover:text-indigo-900">
                                {{ $request->subject }} - Status: {{ ucfirst($request->status) }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-6">
                    <a href="{{ route('support.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 transition ease-in-out duration-150">
                        Criar Nova Solicitação
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
