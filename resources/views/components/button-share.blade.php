<!-- Componente ButtonShare -->
<x-button icon="fas fa-paper-plane" color="{{ $color ?? 'blue' }}" size="{{ $size ?? 'sm' }}" id="{{ $id }}" ariaLabel="{{ $ariaLabel }}">
    {{ $slot }}
</x-button>

<script>
    document.getElementById('{{ $id }}').addEventListener('click', function() {
        // Criando a mensagem combinada com o texto e o URL para garantir que o link seja clicável
        const shareText = '{{ $text }}\n{{ $url }}';  // Combinando o texto e o URL em uma única string

        const shareData = {
            title: '{{ $title }}',
            text: shareText,
            url: '{{ $url }}'  // Pode ser mantido, mas o foco é garantir que o 'text' inclua o link.
        };

        if (navigator.share) {
            // Usando a API de compartilhamento da Web
            navigator.share({
                title: shareData.title,
                text: shareData.text
            })
            .then(() => console.log('Compartilhado com sucesso'))
            .catch((error) => console.log('Erro ao compartilhar:', error));
        } else {
            // Fallback se a Web Share API não for suportada
            navigator.clipboard.writeText(shareText)
                .then(() => alert('Link copiado para a área de transferência!'))
                .catch(err => console.error('Erro ao copiar link: ', err));
        }
    });
</script>
