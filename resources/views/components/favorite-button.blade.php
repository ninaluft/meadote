<button
    onclick="toggleFavorite(event, {{ $petId }}, {{ Auth::check() ? 'true' : 'false' }})"
    class="favorite-btn"
    id="favorite-btn-{{ $petId }}"
    title="{{ $isFavorited ? 'Desfavoritar' : 'Favoritar' }}"
>
    <i id="favorite-icon-{{ $petId }}" class="{{ $isFavorited ? 'fas' : 'far' }} fa-heart text-red-500 hover:text-red-700 text-2xl"></i>
</button>

<script>
    async function toggleFavorite(event, petId, isAuthenticated) {
        event.preventDefault();
        event.stopPropagation();

        if (!isAuthenticated) {
            // Se o usuário não estiver autenticado, redireciona para a página de login
            window.location.href = '{{ route("login", ["redirectTo" => request()->fullUrl()]) }}';
            return;
        }

        try {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch(`/pets/${petId}/favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            });

            if (response.ok) {
                const data = await response.json();

                const icon = document.getElementById(`favorite-icon-${petId}`);
                const button = document.getElementById(`favorite-btn-${petId}`);

                if (data.favorited) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    button.title = 'Desfavoritar';
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    button.title = 'Favoritar';
                }
            } else {
                console.error('Erro ao favoritar/desfavoritar o pet:', response.statusText);
            }
        } catch (error) {
            console.error('Erro ao favoritar/desfavoritar o pet:', error);
        }
    }
</script>
