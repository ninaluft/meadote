@props([
    'icon' => null, // Ícone opcional
    'color' => 'gray', // Cor do botão, com padrão 'gray'
    'size' => 'md', // Tamanho do botão: 'sm', 'md', 'lg'
    'ariaLabel' => '', // Acessibilidade
    'submit' => false, // Define se o botão é de submissão
    'href' => null, // URL para links (se for definido, renderiza um <a>)
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
        'sm' => 'px-3 py-2 text-sm',
        'lg' => 'px-6 py-3 text-lg',
        default => 'px-4 py-2 text-md',
    };

    // Tipo do botão (apenas para botões, não afeta links)
    $buttonType = $submit ? 'submit' : 'button';
@endphp

@if ($href)
    <!-- Renderiza um link se href for definido -->
    <a href="{{ $href }}"
        {{ $attributes->merge(['class' => "inline-flex items-center $sizeClasses $colorClasses rounded-md text-white focus:outline-none disabled:opacity-50"]) }}
        aria-label="{{ $ariaLabel }}">
        @if ($icon)
            <i class="{{ $icon }} mr-2" aria-hidden="true"></i>
        @endif
        {{ $slot }}
    </a>
@else
    <!-- Renderiza um botão se href não for definido -->
    <button
        {{ $attributes->merge(['type' => $buttonType, 'class' => "inline-flex items-center $sizeClasses $colorClasses rounded-md text-white focus:outline-none disabled:opacity-50"]) }}
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
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
        </span>
    </button>
@endif

<script>
    function handleButtonClick(button) {
        const form = button.closest('form');
        if (!form) return;

        // Verificar se todos os campos obrigatórios estão preenchidos
        const invalidFields = validateForm(form);

        if (invalidFields.length === 0) {
            // Exibe o spinner no botão
            showSpinner(button);

            // Exibe o loader global (se existir)
            const generalLoader = document.getElementById('loading');
            if (generalLoader) {
                generalLoader.style.display = 'flex';
            }

            // Desativa o botão para evitar múltiplos cliques
            button.disabled = true;

            // Envia o formulário
            form.submit();
        } else {
            alert(`Por favor, preencha os seguintes campos obrigatórios:\n- ${invalidFields.join('\n- ')}`);
        }
    }

    function validateForm(form) {
        // Seleciona todos os campos obrigatórios no formulário
        const requiredFields = form.querySelectorAll('[required]');
        const invalidFields = [];

        // Verifica se cada campo obrigatório está preenchido
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                invalidFields.push(getFieldLabel(field));
                field.classList.add('border-red-500'); // Adiciona uma borda vermelha para destacar o erro
            } else {
                field.classList.remove('border-red-500'); // Remove a borda vermelha se estiver preenchido
            }
        });

        return invalidFields;
    }

    function getFieldLabel(field) {
        // Tenta capturar o label associado ao campo
        const label = field.closest('div').querySelector('label');
        return label ? label.innerText : field.name || 'Campo sem nome';
    }

    function showSpinner(button) {
        // Esconde o conteúdo original do botão e exibe o spinner
        button.querySelector('.button-content').style.display = 'none';
        button.querySelector('.spinner').style.display = 'flex';
        button.classList.add('opacity-50', 'cursor-not-allowed'); // Aparência desativada
    }
</script>
