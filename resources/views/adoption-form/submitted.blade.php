<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulários de adoção enviados por mim') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                @if($adoptionForms->isEmpty())
                    <p class="text-gray-600">Você não submeteu nenhum formulário de adoção.</p>
                @else
                    <ul class="space-y-6">
                        @foreach($adoptionForms as $form)
                            <li class="p-6 bg-gray-50 rounded-lg shadow-sm border border-gray-200">
                                <!-- Informações do Pet -->
                                <h3 class="text-xl font-semibold mb-2">{{ __('Você aplicou para adotar ') . $form->pet_name }}</h3>

                                <!-- Motivação e Status -->
                                <p class="text-sm text-gray-700"><strong>{{ __('Motivação:') }}</strong> {{ $form->adoption_reason }}</p>
                                <p class="text-sm text-gray-700"><strong>{{ __('Status:') }}</strong> {{ __(ucfirst($form->status)) }}</p>

                                <!-- Link para Visualizar Formulário -->
                                <a href="{{ route('adoption-form.show', $form->id) }}" class="text-indigo-600 hover:underline mt-4 inline-block font-semibold">
                                    {{ __('Ver Formulário') }}
                                </a>

                                <!-- Botão de Cancelar Solicitação -->
                                @if(strtolower($form->status) === 'pendente')
                                    <form action="{{ route('adoption-form.cancel', $form->id) }}" method="POST" class="inline-block mt-4">
                                        @csrf
                                        @method('DELETE')
                                        <x-button class="bg-red-500 hover:bg-red-600 text-white" onclick="return confirm('Tem certeza que deseja cancelar esta solicitação?');">
                                            {{ __('Cancelar Solicitação') }}
                                        </x-button>
                                    </form>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
