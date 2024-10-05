const cacheName = 'xulfashion-business-v1';
const assetsToCache = [
    '', // Placeholder for the start URL for business
    'manifest/offline-business',
    'mobile/css/style.css', // Main CSS for the client
    'mobile/js/script.js', // Main JS for the client
    'xulfashion_business.png', // PWA icon
];

// Fetch the placeholder and activate caching
self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open(cacheName).then(function(cache) {
            return cache.addAll(assetsToCache);
        })
    );
    console.log('Xulfashion Business Service Worker Installed');
});

// Fetch request handling
self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request).then(function(response) {
            return response || fetch(event.request).catch(() => {
                return caches.match('/manifest/offline-business');
            });
        })
    );
});
