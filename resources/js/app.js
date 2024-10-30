import './bootstrap';
import { EmojiButton } from '@joeattardi/emoji-button';

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('/service-worker.js')
        .then((registration) => {
          console.log('Service Worker registered: ', registration);
        })
        .catch((registrationError) => {
          console.log('Service Worker registration failed: ', registrationError);
        });
    });
}



document.addEventListener('DOMContentLoaded', function () {
    const picker = new EmojiButton();
    const emojiBtn = document.getElementById('emoji-btn');
    const contentInput = document.getElementById('content');

    // Verifique se o botão de emoji e o campo de texto existem
    if (emojiBtn && contentInput) {
        emojiBtn.addEventListener('click', function () {
            picker.togglePicker(emojiBtn);
        });

        picker.on('emoji', selection => {
            contentInput.value += selection.emoji;
        });
    }
});


//*--NAVEGAÇAO MOBILE: ------------------------------

// Variáveis para armazenar a posição inicial do toque
let startX = 0;
let startY = 0;

// Evento de início do toque
document.addEventListener('touchstart', (e) => {
    startX = e.touches[0].clientX;
    startY = e.touches[0].clientY;
});

// Evento final do toque
document.addEventListener('touchend', (e) => {
    const endX = e.changedTouches[0].clientX;
    const endY = e.changedTouches[0].clientY;
    const threshold = 250; // Distância mínima para ativar o gesto horizontal
    const verticalLimit = 30; // Limite de movimento vertical para não confundir gestos diagonais

    const horizontalDistance = endX - startX;
    const verticalDistance = Math.abs(endY - startY);

    if (verticalDistance < verticalLimit) { // Garante que o movimento é quase horizontal
        if (horizontalDistance > threshold) {
            // Gesto de deslizar para a direita (voltar)
            window.history.back();
        } else if (horizontalDistance < -threshold) {
            // Gesto de deslizar para a esquerda (avançar)
            // Ação personalizada para avançar (por exemplo, window.history.forward())
        }
    }
});

//*-----------------------------------------

