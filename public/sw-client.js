let cacheName = 'xulfashion-client-v1';
let assetsToCache = [
    '', // Placeholder for the start URL to be received dynamically
    'manifest/offline-client', // Offline page for client PWA
    'mobile/css/style.css', // Main CSS for the client
    'mobile/js/script.js', // Main JS for the client
    'xulfashion_client.png', // PWA icon
];

// Install event for caching static assets
self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open(cacheName).then(function(cache) {
            return cache.addAll(assetsToCache);
        })
    );
    console.log('Xulfashion Client Service Worker Installed');
});

// Message event listener to dynamically cache the start URL
self.addEventListener('message', function(event) {
    if (event.data && event.data.action === 'cache-start-url') {
        let startUrl = event.data.url;
        assetsToCache[0] = startUrl; // Set the start URL dynamically

        caches.open(cacheName).then(function(cache) {
            cache.add(startUrl); // Cache the start URL dynamically
        });
    }
});

// Fetch event to handle requests, including serving the offline page when offline
self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request).then(function(response) {
            return response || fetch(event.request).catch(() => {
                return caches.match('/manifest/offline-client');
            });
        })
    );
});

self.addEventListener('activate', function(event) {
    event.waitUntil(
        caches.keys().then(function(keyList) {
            return Promise.all(
                keyList.map(function(key) {
                    if (key !== cacheName) {
                        return caches.delete(key); // Delete old caches
                    }
                })
            );
        })
    );
    console.log('Xulfashion Client Service Worker Activated');
});