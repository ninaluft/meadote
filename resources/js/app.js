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

// Variável para armazenar a posição inicial do toque
let startX = 0;

// Evento de início do toque
document.addEventListener('touchstart', (e) => {
    startX = e.touches[0].clientX;
});

// Evento final do toque
document.addEventListener('touchend', (e) => {
    const endX = e.changedTouches[0].clientX;
    const threshold = 50; // Define a distância mínima para acionar o gesto de deslizar

    if (startX - endX > threshold) {
        // Gesto de deslizar para a esquerda (pode ser usado para avançar)
        // Ação personalizada para avançar (por exemplo, window.history.forward())
    } else if (endX - startX > threshold) {
        // Gesto de deslizar para a direita (voltar)
        window.history.back();
    }
});

//*-----------------------------------------
