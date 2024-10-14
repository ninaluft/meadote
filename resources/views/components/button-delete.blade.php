<!-- Componente ButtonDelete -->
<form action="{{ $action }}" method="POST" class="inline-block" onsubmit="return confirm('{{ $confirmMessage }}');">
    @csrf
    @method('DELETE')
    <x-button icon="fas fa-trash" size="sm" color="red" ariaLabel="Excluir evento">
        {{ $slot }}
    </x-button>
</form>
