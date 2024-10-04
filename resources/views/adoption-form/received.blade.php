<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulários de Adoção Recebidos') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Seção de Formulários Pendentes -->
                <h3 class="text-lg font-semibold mb-4">{{ __('Formulários de Adoção Pendentes') }}</h3>
                @if($pendingForms->isEmpty())
                    <p>Nenhum formulário de adoção pendente.</p>
                @else
                    <ul>
                        @foreach($pendingForms as $form)
                            <li class="mb-4">
                                <h4>{{ $form->submitter_name }} aplicou para adotar {{ $form->pet->name }}</h4>
                                <p><strong>Motivação:</strong> {{ $form->adoption_reason }}</p>
                                <p><strong>Status:</strong> {{ ucfirst($form->status) }}</p>
                                <a href="{{ route('adoption-form.show', $form->id) }}" class="text-indigo-600 hover:underline">Ver Formulário</a>
                            </li>
                            <hr class="my-4">
                        @endforeach
                    </ul>
                @endif

                <!-- Seção de Formulários Avaliados -->
                <h3 class="text-lg font-semibold mt-8 mb-4">{{ __('Formulários de Adoção Avaliados') }}</h3>
                @if($evaluatedForms->isEmpty())
                    <p>Nenhum formulário de adoção avaliado.</p>
                @else
                    <ul>
                        @foreach($evaluatedForms as $form)
                            <li class="mb-4">
                                <h4>{{ $form->submitter_name }} aplicou para adotar {{ $form->pet->name }}</h4>
                                <p><strong>Motivação:</strong> {{ $form->adoption_reason }}</p>
                                <p><strong>Status:</strong> {{ ucfirst($form->status) }}</p>
                                <a href="{{ route('adoption-form.show', $form->id) }}" class="text-indigo-600 hover:underline">Ver Formulário</a>
                            </li>
                            <hr class="my-4">
                        @endforeach
                    </ul>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
