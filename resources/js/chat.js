
document.addEventListener('DOMContentLoaded', function() {
    fetchMessages(userId);

    document.getElementById('message-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const messageInput = document.getElementById('message-input');

        axios.post('/messages', {
            message: messageInput.value,
            recipient_id: recipientId
        })
        .then(response => {
            messageInput.value = '';
            fetchMessages(userId);
        })
        .catch(error => {
            console.error('Error sending message:', error);
        });
    });

    window.Echo.private('chat.' + userId)
        .listen('MessageSent', (e) => {
            if (e.user.id === recipientId) {
                const chatWindow = document.getElementById('chat-window');
                chatWindow.innerHTML += `<div><strong>${e.user.name}:</strong> ${e.message.message}</div>`;
                chatWindow.scrollTop = chatWindow.scrollHeight;
            }
        });
});

function fetchMessages(userId) {
    axios.get(`/messages?user=${userId}`).then(response => {
        const chatWindow = document.getElementById('chat-window');
        chatWindow.innerHTML = ''; // Clear existing content

        response.data.forEach(message => {
            chatWindow.innerHTML += `<div><strong>${message.user.name}:</strong> ${message.message}</div>`;
        });

        // Scroll to the bottom of the chat window
        chatWindow.scrollTop = chatWindow.scrollHeight;
    });
}
