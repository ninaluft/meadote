self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open('static-cache-v1').then((cache) => {
            return cache.addAll([
                '/',
                '/offline.html',
                '/build/assets/app-B3LQTCW7.css',  
                '/build/assets/app-GypJqDPw.js',
                '/images/icons/icon-192x192.png',
                '/images/icons/icon-512x512.png',
                '/manifest.json',
            ]);
        })
    );
});





self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request);
        })
    );
});
