// const STATIC_CACHE_NAME = 'static-cache-v1';
// const DYNAMIC_CACHE_NAME = 'dynamic-cache-v1';

// // Instalar Service Worker e cachear recursos estáticos
// self.addEventListener('install', (event) => {
//     event.waitUntil(
//         caches.open(STATIC_CACHE_NAME).then((cache) => {
//             return cache.addAll([
//                 '/',
//                 '/offline.html',
//                 '/images/icons/icon-192x192.png',
//                 '/images/icons/icon-512x512.png',
//                 '/manifest.json',
//                 // Adicione aqui mais recursos estáticos que não mudam
//             ]);
//         })
//     );
// });

// // Evento fetch para servir arquivos cacheados e evitar cache para rotas dinâmicas
// self.addEventListener('fetch', (event) => {
//     const url = new URL(event.request.url);

//     // Evitar cachear rotas dinâmicas que dependem de autenticação
//     if (url.pathname.startsWith('/dashboard') || url.pathname.startsWith('/profile') || url.pathname.startsWith('/login') || url.pathname.startsWith('/register')) {
//         event.respondWith(fetch(event.request));
//         return;
//     }

//     // Usar cache para outros recursos
//     event.respondWith(
//         caches.match(event.request).then((response) => {
//             // Se o recurso estiver no cache, retorná-lo
//             if (response) {
//                 return response;
//             }
//             // Senão, buscar na rede e adicionar ao cache dinâmico
//             return fetch(event.request).then((networkResponse) => {
//                 return caches.open(DYNAMIC_CACHE_NAME).then((cache) => {
//                     // Armazenar a resposta da rede no cache dinâmico, se for permitido
//                     if (event.request.url.startsWith('http')) {
//                         cache.put(event.request.url, networkResponse.clone());
//                     }
//                     return networkResponse;
//                 });
//             });
//         }).catch(() => {
//             // Se falhar, mostrar a página offline, se for uma página de navegação
//             if (event.request.mode === 'navigate') {
//                 return caches.match('/offline.html');
//             }
//         })
//     );
// });

// // Limpeza de caches antigos na ativação
// self.addEventListener('activate', (event) => {
//     const cacheWhitelist = [STATIC_CACHE_NAME, DYNAMIC_CACHE_NAME];
//     event.waitUntil(
//         caches.keys().then((cacheNames) => {
//             return Promise.all(
//                 cacheNames.map((cacheName) => {
//                     if (!cacheWhitelist.includes(cacheName)) {
//                         return caches.delete(cacheName);
//                     }
//                 })
//             );
//         })
//     );
// });
