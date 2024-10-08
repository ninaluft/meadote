@push('meta')
    <meta property="og:title" content="{{ $title }}" />
    <meta property="og:description" content="{{ $description }}" />
    <meta property="og:image" content="{{ $image }}" />
    <meta property="og:url" content="{{ $url }}" />
    <meta property="og:type" content="article" />
@endpush

<div>
    <button id="shareButton"
        class="w-full sm:w-auto bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-5 h-5 mr-2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
        </svg>
        {{ __('Compartilhar') }}
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const title = @json($title);
            const description = @json($description);
            const url = @json($url);

            document.getElementById('shareButton').addEventListener('click', async () => {
                const shareData = {
                    title: title,
                    text: description,
                    url: url
                };

                if (navigator.share) {
                    try {
                        await navigator.share(shareData);
                        alert('Compartilhamento bem-sucedido!');
                    } catch (error) {
                        alert('Erro ao compartilhar: ' + error.message);
                    }
                } else {
                    try {
                        await navigator.clipboard.writeText(shareData.url);
                        alert('Link copiado para a área de transferência!');
                    } catch (error) {
                        alert('Erro ao copiar o link: ' + error.message);
                    }
                }
            });
        });
    </script>

</div>
