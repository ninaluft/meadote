<!-- Modal para exibir detalhes do Pet -->
<div id="petModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative">
        <!-- Botão de Fechar -->
        <button id="closeModal" class="absolute top-2 right-2 text-red-600 font-bold text-2xl">&times;</button>

        <!-- Conteúdo do Modal -->
        <div id="modalContent">
            <!-- Título e Botão de Favorito -->
            <div class="flex items-center justify-between mb-4">
                <h2 id="petName" class="text-3xl font-semibold text-gray-800"></h2>
                <i id="favoriteIcon" class="far fa-heart text-red-500 hover:text-red-700 text-2xl cursor-pointer" onclick="handleFavorite()"></i>
            </div>

            <!-- Imagem do Pet -->
            <img id="petImage" class="rounded-lg w-full h-auto mb-4" alt="Imagem do Pet">

            <!-- Detalhes do Pet -->
            <div class="text-gray-600 space-y-2 text-base" id="petDetails"></div>
        </div>
    </div>
</div>

<script>
    async function openPetModal(petId) {
        try {
            const response = await fetch(`/pets/${petId}`, {
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Erro ao buscar os dados do pet.');
            }

            const petData = await response.json();

            // Preencher o conteúdo do modal com os dados do pet
            document.getElementById('petName').innerText = petData.pet.name;
            document.getElementById('petImage').src = petData.pet.photo_path ? `/storage/${petData.pet.photo_path}` : '/images/default-pet.jpg';
            document.getElementById('petDetails').innerHTML = `
                <p><strong>Espécie:</strong> ${petData.pet.species}</p>
                <p><strong>Sexo:</strong> ${petData.pet.gender}</p>
                <p><strong>Idade:</strong> ${petData.pet.age}</p>
                <p><strong>Porte:</strong> ${petData.pet.size}</p>
                <p><strong>Castrado:</strong> ${petData.pet.is_neutered ? 'Sim' : 'Não'}</p>
                <p><strong>Condições Especiais:</strong> ${petData.pet.special_conditions ? 'Sim' : 'Não'}</p>
                <p><strong>Descrição:</strong> ${petData.pet.description || 'N/A'}</p>
            `;

            // Mostrar o modal
            document.getElementById('petModal').classList.remove('hidden');
        } catch (error) {
            console.error('Erro ao carregar os detalhes do pet:', error);
        }
    }

    // Fechar o modal
    document.getElementById('closeModal').addEventListener('click', () => {
        document.getElementById('petModal').classList.add('hidden');
    });

    // Fechar o modal ao clicar fora dele
    window.addEventListener('click', (event) => {
        const modal = document.getElementById('petModal');
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });

    // Função para lidar com a ação de favoritar (exemplo)
    function handleFavorite() {
        // Verifique se o usuário está autenticado
        if (!@json(Auth::check())) {
            window.location.href = "{{ route('login') }}";
            return;
        }

        // Adicione a lógica para favoritar o pet aqui
        // Esta é uma função de exemplo, adapte-a ao seu caso
        alert("Função de favoritar chamada. Implemente a lógica aqui.");
    }
</script>
