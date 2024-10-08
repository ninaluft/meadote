<div>
    {{-- Pets Favoritados --}}
    <div class="bg-gray-200 p-2 rounded">
        <h3 class="text-xl font-semibold">Pets Favoritados por Outros Usuários ({{ $favoritedPets->count() }})</h3>
    </div>

    @if ($favoritedPets->isEmpty())
        <p class="text-gray-600">Nenhum dos seus pets foi favoritado por outros usuários.</p>
    @else
        <div class="bg-white border rounded-lg overflow-hidden shadow-sm p-6">
            <div class="max-h-64 overflow-y-auto">
                <ul class="list-disc list-inside">
                    @foreach ($favoritedPets as $pet)
                        <li class="mb-4">
                            <a href="{{ route('pets.show', $pet->id) }}"
                                class="text-blue-600 hover:underline font-semibold">
                                {{ $pet->name }}
                            </a>
                            - Favoritado {{ $favoritesCount[$pet->id] ?? 0 }} vez(es)
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>
