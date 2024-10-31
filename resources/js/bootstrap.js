import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.Pusher = Pusher;

// Inicializa o Echo com o Pusher
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    }
});

// Função para inicializar o contador de notificações no menu
function initializeNotificationCount() {
    let notificationCounter = document.querySelector('#notification-count');
    if (notificationCounter) {
        const unreadCount = parseInt(notificationCounter.innerText) || 0;
        notificationCounter.style.display = unreadCount > 0 ? 'inline-block' : 'none';
    }
}

// Função para atualizar o contador de notificações no menu
window.updateNotificationCount = function (newCount = null) {
    let notificationCounter = document.querySelector('#notification-count');
    if (!notificationCounter) {
        const navLink = document.querySelector('[aria-label="Mensagens"]');
        notificationCounter = document.createElement('span');
        notificationCounter.id = 'notification-count';
        notificationCounter.className = 'ml-1 inline-block bg-red-600 text-white text-xs rounded-full px-2 py-1';
        navLink.appendChild(notificationCounter);
    }

    let currentCount = parseInt(notificationCounter.innerText) || 0;
    notificationCounter.innerText = newCount !== null ? newCount : currentCount + 1;
    notificationCounter.style.display = parseInt(notificationCounter.innerText) > 0 ? 'inline-block' : 'none';
};

// Função para exibir mensagens em tempo real na janela da conversa ativa
function displayMessageInChatWindow(message) {
    const chatWindow = document.querySelector('#chat-window'); // Ajuste o seletor conforme seu layout
    if (chatWindow) {
        const newMessageElement = document.createElement('div');
        newMessageElement.classList.add('message'); // Ajuste a classe conforme necessário
        newMessageElement.textContent = message.content;
        chatWindow.appendChild(newMessageElement);
    }
}

// Define o ID do usuário com quem você está em conversa ativa
window.setActiveConversationUserId = function (userId) {
    window.activeConversationUserId = userId;
    console.log("Conversa ativa definida com o usuário:", userId);
};

// Obtém o userId da meta tag e define como variável global
const userIdMeta = document.querySelector('meta[name="user-id"]');
window.userId = userIdMeta ? userIdMeta.getAttribute('content') : null;

if (window.userId) {
    // Escuta o canal de mensagens em tempo real para exibir mensagens diretamente na janela de conversa
    window.Echo.channel('messages-channel-' + window.userId)
        .listen('.MessageSent', (event) => {
            // Se a mensagem é da conversa ativa, exibe na janela de conversa em vez de incrementar notificações
            if (window.activeConversationUserId === event.message.sender_id) {
                displayMessageInChatWindow(event.message);
            } else {
                // Incrementa a contagem de notificações para outras conversas
                updateNotificationCount();
            }
        });

    // Escuta o canal de notificações para atualizar a contagem no menu
    // Escuta o canal de notificações para atualizar a contagem no menu
    window.Echo.channel('notifications-channel-' + window.userId)
        .listen('.NewNotification', (event) => {
            // Incrementa a contagem de notificações apenas se não for a conversa ativa
            if (window.activeConversationUserId !== event.senderId) {
                updateNotificationCount(event.newCount);
            }
        });

}

// Chama a inicialização do contador de notificações ao carregar a página
window.onload = () => {
    initializeNotificationCount();
};
