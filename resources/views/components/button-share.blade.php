<!-- Componente ButtonShare -->
<x-button icon="fas fa-paper-plane" color="{{ $color ?? 'blue' }}" size="{{ $size ?? 'sm' }}" id="{{ $id }}" ariaLabel="{{ $ariaLabel }}">
    {{ $slot }}
</x-button>

<script>
    document.getElementById('{{ $id }}').addEventListener('click', function() {
        const shareData = {
            title: '{{ $title }}',
            text: '{{ $text }}',
            url: '{{ $url }}'
        };

        if (navigator.share) {
            navigator.share(shareData)
                .then(() => console.log('Compartilhado com sucesso'))
                .catch((error) => console.log('Erro ao compartilhar:', error));
        } else {
            // Fallback if Web Share API is not suported
            navigator.clipboard.writeText(shareData.url)
                .then(() => alert('Link copiado para a área de transferência!'))
                .catch(err => console.error('Erro ao copiar link: ', err));
        }
    });
</script>
