<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulários de Adoção') }} - {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <!-- Filtro para alternar entre formulários -->
                <div class="mb-4">
                    <button id="btnSentForms" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="showSentForms()">Formulários Enviados</button>
                    <button id="btnReceivedForms" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded" onclick="showReceivedForms()">Formulários Recebidos</button>
                </div>

                <!-- Seção de Formulários Enviados -->
                <div id="sentForms" class="forms-section">
                    <h3 class="text-lg font-semibold mb-4">Formulários de Adoção Enviados</h3>
                    @if($sentForms->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pet</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data de Envio</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($sentForms as $form)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('adoption-form.show', $form->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                {{ $form->pet_name }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($form->status) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $form->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    @else
                        <p>Nenhum formulário enviado.</p>
                    @endif
                </div>

                <!-- Seção de Formulários Recebidos -->
                <div id="receivedForms" class="forms-section hidden">
                    <h3 class="text-lg font-semibold mb-4">Formulários de Adoção Recebidos</h3>
                    @if($receivedForms->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome do Solicitante</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pet</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data de Envio</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($receivedForms as $form)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('adoption-form.show', $form->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                {{ $form->submitter_name }}
                                            </a>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $form->pet_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($form->status) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $form->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Nenhum formulário recebido.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function showSentForms() {
            document.getElementById('sentForms').classList.remove('hidden');
            document.getElementById('receivedForms').classList.add('hidden');
            document.getElementById('btnSentForms').classList.add('bg-blue-500');
            document.getElementById('btnReceivedForms').classList.remove('bg-blue-500');
        }

        function showReceivedForms() {
            document.getElementById('sentForms').classList.add('hidden');
            document.getElementById('receivedForms').classList.remove('hidden');
            document.getElementById('btnSentForms').classList.remove('bg-blue-500');
            document.getElementById('btnReceivedForms').classList.add('bg-blue-500');
        }
    </script>
</x-app-layout>
