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
    } else {
        console.log('Elementos não encontrados no DOM');
    }
});
