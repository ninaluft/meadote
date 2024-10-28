const STATIC_CACHE_NAME = 'static-cache-v1';
const DYNAMIC_CACHE_NAME = 'dynamic-cache-v1';
const MAX_DYNAMIC_CACHE_ITEMS = 50; // Limite de itens no cache dinâmico

// Rotas dinâmicas que não devem ser cacheadas
const dynamicRoutes = [
    '/dashboard',
    '/profile',
    '/login',
    '/register',
    '/pets/create',
    '/pets/',
    '/user/profile',
    '/user/public-profile',
    '/adoption-form',
    '/messages',
    '/support',
    '/admin',
    '/ong',
    '/tutor'
];

// Instalar Service Worker e cachear recursos estáticos
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(STATIC_CACHE_NAME).then((cache) => {
            return cache.addAll([
                '/',
                '/offline.html',
                '/images/icons/icon-192x192.png',
                '/images/icons/icon-512x512.png',
                '/manifest.json',
                // Adicione mais recursos estáticos conforme necessário
            ]);
        })
    );
});

// Limpeza de caches antigos na ativação
self.addEventListener('activate', (event) => {
    const cacheWhitelist = [STATIC_CACHE_NAME, DYNAMIC_CACHE_NAME];
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (!cacheWhitelist.includes(cacheName)) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});

// Gerenciamento do cache dinâmico com limite de itens
function limitCacheSize(name, size) {
    caches.open(name).then((cache) => {
        cache.keys().then((keys) => {
            if (keys.length > size) {
                cache.delete(keys[0]).then(() => limitCacheSize(name, size));
            }
        });
    });
}

// Evento fetch para servir arquivos cacheados e evitar cache para rotas dinâmicas
self.addEventListener('fetch', (event) => {
    const url = new URL(event.request.url);

    // Verificar se a rota é dinâmica e evitar cache
    if (dynamicRoutes.some(route => url.pathname.startsWith(route))) {
        event.respondWith(fetch(event.request));
        return;
    }

    // Usar cache para outros recursos
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request).then((networkResponse) => {
                return caches.open(DYNAMIC_CACHE_NAME).then((cache) => {
                    // Cachear resposta da rede
                    if (event.request.url.startsWith('http')) {
                        cache.put(event.request.url, networkResponse.clone());
                        limitCacheSize(DYNAMIC_CACHE_NAME, MAX_DYNAMIC_CACHE_ITEMS);
                    }
                    return networkResponse;
                });
            });
        }).catch(() => {
            // Mostrar página offline para falha de navegação
            if (event.request.mode === 'navigate') {
                return caches.match('/offline.html');
            }
        })
    );
});
