<!-- admin/user-pets.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pets Registrados por ') . $user->name }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if($pets->count() > 0)
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Nome</th>
                                <th class="px-4 py-2">Espécie</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pets as $pet)
                                <tr>
                                    <td class="border px-4 py-2">{{ $pet->name }}</td>
                                    <td class="border px-4 py-2">{{ $pet->species }}</td>
                                    <td class="border px-4 py-2">{{ $pet->status }}</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('pets.show', $pet->id) }}" class="text-blue-600 hover:text-blue-900">Ver Detalhes</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Este usuário não registrou nenhum pet.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
