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
                    <p>Você não submeteu nenhum formulário de adoção.</p>
                @else
                    <ul>
                        @foreach($adoptionForms as $form)
                            <li class="mb-4">
                                <!-- Informações do Pet -->
                                <h3 class="text-lg font-semibold">{{ __('Você aplicou para adotar ') . $form->pet_name }}</h3>

                                <!-- Motivação e Status -->
                                <p><strong>{{ __('Motivação:') }}</strong> {{ $form->adoption_reason }}</p>
                                <p><strong>{{ __('Status:') }}</strong> {{ __( $form->status) }}</p>

                                <!-- Link para Visualizar Formulário -->
                                <a href="{{ route('adoption-form.show', $form->id) }}" class="text-indigo-600 hover:underline">
                                    {{ __('Ver Formulário') }}
                                </a>

                                <!-- Botão de Cancelar Solicitação -->
                                @if($form->status === 'Pendente')
                                    <form action="{{ route('adoption-form.cancel', $form->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-button class="bg-red-500 hover:bg-red-600 mt-2" onclick="return confirm('Tem certeza que deseja cancelar esta solicitação?');">
                                            {{ __('Cancelar Solicitação') }}
                                        </x-button>
                                    </form>
                                @endif
                            </li>
                            <hr class="my-4">
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
