import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

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


// Obtém o userId da meta tag e define como variável global
const userIdMeta = document.querySelector('meta[name="user-id"]');
window.userId = userIdMeta ? userIdMeta.getAttribute('content') : null;

// Adiciona o listener de evento para as notificações
if (window.userId) {
    window.Echo.channel('notifications-channel-' + window.userId)
        .listen('.NewNotification', (event) => {
            console.log("New notification event received:", event); // Verifica se o evento é recebido e o valor de `newCount`
            updateNotificationCount(event.newCount); // Passa o valor de `newCount` vindo do evento
        });
} else {
    console.log("User ID is not defined. Ensure the meta tag is present and has the correct value.");
}


// Define a função de atualização de contagem de notificações como global
window.updateNotificationCount = function(newCount) {
    setTimeout(() => {
        let notificationCounter = document.querySelector('#notification-count');
        if (notificationCounter) {
            console.log("Counter element found:", notificationCounter);
            notificationCounter.innerHTML = newCount > 0 ? newCount : '';
            console.log("Notification count updated to:", newCount);
        } else {
            console.log("Notification counter element not found");
        }
    }, 100); // Ajuste o tempo, se necessário
};


