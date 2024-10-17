<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Solicitações de Suporte') }}
        </h2>
    </x-slot>

    <section class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">

                <h3 class="text-lg font-semibold mb-4">{{ __('Suas Solicitações') }}</h3>

                <!-- List of Support Requests -->
                <ul class="space-y-2">
                    @forelse ($supportRequests as $request)
                        <li>
                            <a href="{{ route('support.show', $request) }}" class="text-indigo-600 hover:text-indigo-900 underline">
                                {{ $request->subject }} - {{ __('Status: ') . __('messages.status.' . $request->status) }}
                            </a>
                        </li>
                    @empty
                        <p class="text-gray-500">{{ __('Você não possui solicitações no momento.') }}</p>
                    @endforelse
                </ul>

                <!-- Create New Support Request Button -->
                <div class="mt-6">
                    <a href="{{ route('support.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring ring-blue-300 transition ease-in-out duration-150">
                        {{ __('Criar Nova Solicitação') }}
                    </a>
                </div>

            </div>
        </div>
    </section>
</x-app-layout>
