const STATIC_CACHE_NAME = 'static-cache-v1';
const DYNAMIC_CACHE_NAME = 'dynamic-cache-v1';
const MAX_DYNAMIC_CACHE_ITEMS = 50;

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
    '/tutor',
    '/posts',
    '/all-pets',
    '/',
];

// Instala o Service Worker e cacheia os recursos estáticos
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(STATIC_CACHE_NAME).then((cache) => {
            return cache.addAll([
                '/',
                '/offline.html',
                '/images/icons/icon-192x192.png',
                '/images/icons/icon-512x512.png',
                '/manifest.json',
            ]);
        })
    );
    self.skipWaiting(); // Garante que o SW ativo seja atualizado imediatamente
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
    return self.clients.claim();
});

// Limita o tamanho do cache dinâmico
async function limitCacheSize(name, size) {
    const cache = await caches.open(name);
    const keys = await cache.keys();
    if (keys.length > size) {
        await cache.delete(keys[0]);
        limitCacheSize(name, size);
    }
}

// Evento fetch para servir arquivos cacheados e evitar cache para rotas dinâmicas
self.addEventListener('fetch', (event) => {
    const url = new URL(event.request.url);

    // Verifica se a rota é dinâmica e evita cache
    if (dynamicRoutes.some(route => url.pathname.startsWith(route))) {
        event.respondWith(fetch(event.request));
        return;
    }

    // Cacheia somente recursos que não são documentos (como HTML)
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request).then((networkResponse) => {
                if (!networkResponse.ok || networkResponse.headers.get('Cache-Control')?.includes('no-store')) {
                    return networkResponse;
                }
                return caches.open(DYNAMIC_CACHE_NAME).then((cache) => {
                    if (event.request.destination === 'image' || event.request.destination === 'script' || event.request.destination === 'style') {
                        cache.put(event.request, networkResponse.clone());
                        limitCacheSize(DYNAMIC_CACHE_NAME, MAX_DYNAMIC_CACHE_ITEMS);
                    }
                    return networkResponse;
                });
            });
        }).catch(() => {
            if (event.request.mode === 'navigate') {
                return caches.match('/offline.html');
            }
        })
    );
});

// Força a atualização do SW ativo
self.addEventListener('message', (event) => {
    if (event.data === 'skipWaiting') {
        self.skipWaiting();
    }
});
