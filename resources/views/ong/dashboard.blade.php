<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel da ONG') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">


                <!-- Outras seções da dashboard -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <!-- Registrar Novo Pet -->
                    <div class="bg-blue-100 p-4 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold mb-2">{{ __('Registrar Novo Pet') }}</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            {{ __('Adicione um novo pet ao sistema e facilite sua adoção.') }}
                        </p>
                        <a href="{{ route('pets.create') }}"
                            class="inline-block bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600" aria-label="Registrar um novo pet">
                            {{ __('Registrar Pet') }}
                        </a>
                    </div>

                    <!-- Gerenciar Pets -->
                    <div class="bg-green-100 p-4 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold mb-2">{{ __('Gerenciar Pets') }}</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            {{ __('Veja e gerencie todos os pets que você cadastrou.') }}
                        </p>
                        <a href="{{ route('pets.my-pets') }}"
                            class="inline-block bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600" aria-label="Ver e gerenciar seus pets">
                            {{ __('Ver Pets') }}
                        </a>
                    </div>

                    <!-- Criar Evento -->
                    <div class="bg-purple-100 p-4 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold mb-2">{{ __('Criar Evento') }}</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            {{ __('Crie eventos para promover adoções e envolvimento da comunidade.') }}
                        </p>
                        <a href="{{ route('events.criar') }}"
                            class="inline-block bg-purple-500 text-white py-2 px-4 rounded-lg hover:bg-purple-600" aria-label="Criar um novo evento">
                            {{ __('Criar Evento') }}
                        </a>
                    </div>

                    <!-- Ver Eventos -->
                    <div class="bg-yellow-100 p-4 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold mb-2">{{ __('Ver Eventos') }}</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            {{ __('Veja os eventos já criados pela sua ONG.') }}
                        </p>
                        <a href="{{ route('ong-events.index') }}"
                            class="inline-block bg-yellow-500 text-white py-2 px-4 rounded-lg hover:bg-yellow-600" aria-label="Ver eventos criados pela ONG">
                            {{ __('Ver Eventos') }}
                        </a>
                    </div>

                    <!-- Formulários de Adoção Recebidos -->
                    <div class="bg-red-100 p-4 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold mb-2">{{ __('Formulários de Adoção Recebidos') }}</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            {{ __('Gerencie os formulários de adoção recebidos.') }}
                        </p>
                        <a href="{{ route('adoption-form.received') }}"
                            class="inline-block bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600" aria-label="Ver formulários de adoção recebidos">
                            {{ __('Ver Formulários') }}
                        </a>
                    </div>

                    <!-- Mensagens -->
                    <div class="bg-indigo-100 p-4 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold mb-2">{{ __('Mensagens') }}</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            {{ __('Veja e responda mensagens enviadas por usuários interessados.') }}
                        </p>
                        <a href="{{ route('messages.inbox') }}"
                            class="inline-block bg-indigo-500 text-white py-2 px-4 rounded-lg hover:bg-indigo-600" aria-label="Ver mensagens recebidas">
                            {{ __('Ver Mensagens') }}
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
