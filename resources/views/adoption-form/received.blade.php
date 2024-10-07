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
                <div class="bg-gray-200 p-4 mb-6 rounded">
                    <h3 class="text-lg font-semibold">{{ __('Formulários de Adoção Pendentes') }}</h3>
                </div>
                @if($pendingForms->isEmpty())
                    <p class="text-gray-600">Nenhum formulário de adoção pendente.</p>
                @else
                    <ul class="space-y-6">
                        @foreach($pendingForms as $form)
                            <li class="p-4 bg-white shadow rounded-lg">
                                <h4 class="text-md font-bold">{{ $form->submitter_name }} aplicou para adotar {{ $form->pet->name }}</h4>
                                <p class="text-sm text-gray-600 mt-2"><strong>Motivação:</strong> {{ $form->adoption_reason }}</p>
                                <p class="text-sm text-gray-600"><strong>Status:</strong> {{ ucfirst($form->status) }}</p>
                                <a href="{{ route('adoption-form.show', $form->id) }}" class="text-indigo-600 hover:underline mt-2 inline-block">Ver Formulário</a>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <!-- Seção de Formulários Avaliados -->
                <div class="bg-gray-200 p-4 mt-8 mb-6 rounded">
                    <h3 class="text-lg font-semibold">{{ __('Formulários de Adoção Avaliados') }}</h3>
                </div>
                @if($evaluatedForms->isEmpty())
                    <p class="text-gray-600">Nenhum formulário de adoção avaliado.</p>
                @else
                    <ul class="space-y-6">
                        @foreach($evaluatedForms as $form)
                            <li class="p-4 bg-white shadow rounded-lg">
                                <h4 class="text-md font-bold">{{ $form->submitter_name }} aplicou para adotar {{ $form->pet->name }}</h4>
                                <p class="text-sm text-gray-600 mt-2"><strong>Motivação:</strong> {{ $form->adoption_reason }}</p>
                                <p class="text-sm text-gray-600"><strong>Status:</strong> {{ ucfirst($form->status) }}</p>
                                <a href="{{ route('adoption-form.show', $form->id) }}" class="text-indigo-600 hover:underline mt-2 inline-block">Ver Formulário</a>
                            </li>
                        @endforeach
                    </ul>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
