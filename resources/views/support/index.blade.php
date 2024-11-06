<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Solicitações de Suporte') }}
        </h2>
    </x-slot>

    <section class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 space-y-8">

                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">{{ __('Suas Solicitações de Suporte') }}</h3>
                    <a href="{{ route('support.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring ring-blue-300 transition ease-in-out duration-150">
                        {{ __('Criar Nova Solicitação') }}
                    </a>
                </div>

                <!-- Grouped Support Requests by Status -->
                @foreach (['open' => 'Abertas', 'closed' => 'Encerradas'] as $status => $label)
                    <div class="border-b border-gray-200 pb-4 mb-4">
                        <h4 class="font-semibold text-gray-700 mb-2">{{ __($label) }}</h4>
                        <ul class="space-y-2">
                            @forelse ($supportRequests->where('status', $status) as $request)
                                <li class="flex items-center">
                                    <a href="{{ route('support.show', $request) }}"
                                        class="text-indigo-600 hover:text-indigo-900 underline">
                                        {{ $request->subject }}
                                    </a>
                                    <span class="ml-2 text-sm text-gray-500">
                                        - {{ __('Status: ') . __('messages.status.' . $request->status) }}
                                    </span>
                                </li>
                            @empty
                                <p class="text-gray-500">{{ __("Não há solicitações $label.") }}</p>
                            @endforelse
                        </ul>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
</x-app-layout>
