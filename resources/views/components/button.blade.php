@props([
    'icon' => null, // Ícone opcional
    'color' => 'gray', // Cor do botão, com padrão 'gray'
    'size' => 'md', // Tamanho do botão: 'sm', 'md', 'lg'
    'href' => null, // Link opcional para transformar o botão em um link
    'ariaLabel' => '', // Acessibilidade
])

@php
    // Classes para cores
    $colorClasses = match ($color) {
        'yellow' => 'bg-yellow-500 hover:bg-yellow-600 text-white',
        'red' => 'bg-red-500 hover:bg-red-600 text-white',
        'blue' => 'bg-blue-500 hover:bg-blue-600 text-white',
        'green' => 'bg-green-500 hover:bg-green-600 text-white',
        default => 'bg-gray-800 hover:bg-gray-700 text-white',
    };

    // Classes para o tamanho
    $sizeClasses = match ($size) {
        'sm' => 'px-3 py-2 text-md',
        'lg' => 'px-6 py-3 text-lg',
        default => 'px-4 py-2 text-md',
    };
@endphp

@if ($href)
    <a href="{{ $href }}"
        {{ $attributes->merge(['class' => "inline-flex items-center $sizeClasses $colorClasses rounded-md text-white focus:outline-none disabled:opacity-50"]) }}
        aria-label="{{ $ariaLabel }}">
        @if ($icon)
            <i class="{{ $icon }} mr-2" aria-hidden="true"></i>
        @endif
        <span class="button-content">{{ $slot }}</span>
    </a>
@else
    <button
        {{ $attributes->merge(['type' => 'submit', 'class' => "inline-flex items-center $sizeClasses $colorClasses rounded-md text-white focus:outline-none disabled:opacity-50"]) }}
        aria-label="{{ $ariaLabel }}" onclick="handleButtonClick(this)">
        <span class="button-content flex items-center">
            @if ($icon)
                <i class="{{ $icon }} mr-2" aria-hidden="true"></i>
            @endif
            {{ $slot }}
        </span>
        <span class="spinner" style="display:none;">
            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
        </span>
    </button>
@endif



<script>
    function handleButtonClick(button) {
        // Exibe o spinner e desabilita o conteúdo do botão
        showSpinner(button);

        // Simula o processo de ação (exemplo, substitua com a sua lógica)
        setTimeout(() => {
            hideSpinner(button); // Esconde o spinner após a ação simulada
        }, 2000); // Ajuste conforme sua necessidade
    }

    // Exemplo de compartilhamento ou outra ação que você pode realizar:
    /*
    navigator.share({
        title: 'Exemplo',
        text: 'Texto de exemplo',
        url: 'https://seu-site.com'
    })
    .then(() => hideSpinner(button))
    .catch(() => hideSpinner(button));
    */

    function showSpinner(button) {
        // Esconde o conteúdo original do botão e exibe o spinner
        button.querySelector('.button-content').style.display = 'none';
        button.querySelector('.spinner').style.display = 'flex';
        button.classList.add('opacity-50', 'cursor-not-allowed'); // Aparência desativada
    }

    function hideSpinner(button) {
        // Restaura o conteúdo original do botão e esconde o spinner
        button.querySelector('.button-content').style.display = 'flex';
        button.querySelector('.spinner').style.display = 'none';
        button.classList.remove('opacity-50', 'cursor-not-allowed'); // Remove aparência desativada
    }
</script>
