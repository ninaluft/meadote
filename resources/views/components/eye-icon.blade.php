<!-- resources/views/components/eye-icon.blade.php -->
<button type="button" class="absolute inset-y-11 right-0 pr-3 flex items-center text-gray-500"
    onclick="togglePassword('{{ $fieldId }}', this)" title="Visualizar senha">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M13.875 18.825A10.05 10.05 0 0112 19c-5.25 0-9.747-3.11-11.542-7 1.045-2.418 2.985-4.43 5.333-5.656M4.47 4.47l15.06 15.06M9.1 9.1a3 3 0 114.8 4.8" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9.879 5.121A10.053 10.053 0 0112 5c5.25 0 9.747 3.11 11.542 7a11.05 11.05 0 01-1.507 2.518M4.47 4.47l15.06 15.06" />
    </svg>
</button>

<script>
    function togglePassword(fieldId, button) {
        var passwordInput = document.getElementById(fieldId);
        var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Troca o ícone entre olho normal e olho riscado
        const eyeIcon = button.querySelector('svg');
        if (type === 'password') {
            // Olho riscado (senha oculta)
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-5.25 0-9.747-3.11-11.542-7 1.045-2.418 2.985-4.43 5.333-5.656M4.47 4.47l15.06 15.06M9.1 9.1a3 3 0 114.8 4.8" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 5.121A10.053 10.053 0 0112 5c5.25 0 9.747 3.11 11.542 7a11.05 11.05 0 01-1.507 2.518M4.47 4.47l15.06 15.06" />
            `;
        } else {
            // Olho normal (senha visível)
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.757 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.299 7-9.542 7S3.732 16.057 2.458 12z" />
            `;
        }
    }
</script>
