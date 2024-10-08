<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel do Tutor') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- Seção de Ações -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <!-- Registrar Novo Pet -->
                    <div class="bg-blue-100 p-4 rounded-lg shadow-md flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">{{ __('Registrar Novo Pet') }}</h3>
                            <p class="text-sm text-gray-600 mb-4">
                                {{ __('Adicione um novo pet ao sistema e facilite sua adoção.') }}
                            </p>
                        </div>
                        <a href="{{ route('pets.create') }}"
                            class="inline-block bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 mt-auto text-center"
                            aria-label="Registrar um novo pet">
                            {{ __('Registrar Pet') }}
                        </a>
                    </div>

                    <!-- Ver Meus Pets -->
                    <div class="bg-green-100 p-4 rounded-lg shadow-md flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">{{ __('Ver Meus Pets') }}</h3>
                            <p class="text-sm text-gray-600 mb-4">
                                {{ __('Veja todos os pets que você cadastrou no sistema.') }}
                            </p>
                        </div>
                        <a href="{{ route('pets.my-pets') }}"
                            class="inline-block bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 mt-auto text-center"
                            aria-label="Ver os pets cadastrados por você">
                            {{ __('Meus Pets') }}
                        </a>
                    </div>

                    <!-- Formulários de Adoção Enviados -->
                    <div class="bg-yellow-100 p-4 rounded-lg shadow-md flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">{{ __('Formulários de Adoção Enviados') }}</h3>
                            <p class="text-sm text-gray-600 mb-4">
                                {{ __('Veja os formulários de adoção que você enviou.') }}
                            </p>
                        </div>
                        <a href="{{ route('adoption-form.submitted') }}"
                            class="inline-block bg-yellow-500 text-white py-2 px-4 rounded-lg hover:bg-yellow-600 mt-auto text-center"
                            aria-label="Ver os formulários de adoção que você enviou">
                            {{ __('Ver Formulários') }}
                        </a>
                    </div>

                    <!-- Formulários de Adoção Recebidos -->
                    <div class="bg-purple-100 p-4 rounded-lg shadow-md flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">{{ __('Formulários de Adoção Recebidos') }}</h3>
                            <p class="text-sm text-gray-600 mb-4">
                                {{ __('Gerencie os formulários recebidos para os pets cadastrados.') }}
                            </p>
                        </div>
                        <a href="{{ route('adoption-form.received') }}"
                            class="inline-block bg-purple-500 text-white py-2 px-4 rounded-lg hover:bg-purple-600 mt-auto text-center"
                            aria-label="Ver formulários de adoção recebidos">
                            {{ __('Ver Formulários Recebidos') }}
                        </a>
                    </div>

                    <!-- Lar Temporário -->
                    <div class="bg-red-100 p-4 rounded-lg shadow-md flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">{{ __('Lar Temporário') }}</h3>
                            <p class="text-sm text-gray-600 mb-4">
                                {{ __('Procure por usuaários que oferecem lar temporário perto de você.') }}
                            </p>
                        </div>
                        <a href="{{ route('temporary-housing.index') }}"
                            class="inline-block bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 mt-auto text-center"
                            aria-label="Procurar lar temporário">
                            {{ __('Procurar Lar Temporário') }}
                        </a>
                    </div>

                    <!-- Favoritos -->
                    <div class="bg-indigo-100 p-4 rounded-lg shadow-md flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">{{ __('Pets Favoritos') }}</h3>
                            <p class="text-sm text-gray-600 mb-4">
                                {{ __('Veja os pets que você marcou como favoritos.') }}
                            </p>
                        </div>
                        <a href="{{ route('pets.favorites') }}"
                            class="inline-block bg-indigo-500 text-white py-2 px-4 rounded-lg hover:bg-indigo-600 mt-auto text-center"
                            aria-label="Ver seus pets favoritos">
                            {{ __('Ver Favoritos') }}
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
