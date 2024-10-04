<div id="userModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Detalhes do Usuário</h3>
                <div class="mt-2">
                    <!-- Detalhes do usuário serão carregados aqui -->
                    <div id="user-details" class="text-sm text-gray-500">
                        <!-- Conteúdo será atualizado dinamicamente -->
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm" onclick="closeModal()">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    function closeModal() {
        document.getElementById('userModal').classList.add('hidden'); // Esconder modal
    }

    function showUserDetails(userId) {
        document.getElementById('userModal').classList.remove('hidden'); // Exibir modal
        document.getElementById('user-details').innerHTML = `<p>Carregando dados do usuário...</p>`; // Mostrar que o modal está ativo

        // Tente buscar os detalhes do usuário via AJAX
        fetch(`/admin/user-details/${userId}`)
            .then(response => response.json())
            .then(data => {
                // Exibir detalhes do usuário, incluindo formulários de adoção enviados e recebidos
                document.getElementById('user-details').innerHTML = `
                    <p><strong>Nome:</strong> ${data.name}</p>
                    <p><strong>Email:</strong> ${data.email}</p>
                    <p><strong>Tipo de Usuário:</strong> ${data.user_type}</p>
                    <p><strong>Animais Registrados:</strong> ${data.animals_count}</p>
                    <p><strong>Formulários Enviados:</strong> ${data.forms_count}</p>
                    <p><strong>Formulários Recebidos:</strong> ${data.received_forms_count}</p>
                    <p><strong>Cidade:</strong> ${data.city}</p>
                    <p><strong>Estado:</strong> ${data.state}</p>
                    <p><strong>CEP:</strong> ${data.cep}</p>
                    <div class="mt-4">
                        <a href="/admin/user-forms/${userId}" class="text-blue-500 hover:underline">Ver Formulários</a>

                    </div>
                `;
            })
            .catch(error => {
                document.getElementById('user-details').innerHTML = `<p>Erro ao carregar os dados.</p>`;
            });
    }
</script>
