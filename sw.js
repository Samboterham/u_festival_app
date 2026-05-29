const CACHE_NAME = 'ufestival-cache-v1';
const STATIC_ASSETS = [
  'index.php',
  'lineup.php',
  'map.php',
  'info.php',
  'style.css',
  'theme.js',
  'qrious.min.js',
  'pwa-helper.js',
  'offline.html',
  'images/pwa-icon.svg',
  'images/logo_white.svg',
  'images/kaart_festival_markers (2).svg',
  'images/home-black.png',
  'images/info-black.png',
  'images/music-black.png',
  'images/pin-black.png',
  'images/dutch.png',
  'images/english.png',
  'images/night-mode.png',
  'images/arrow-down.png'
];

// Install Event: cache static assets
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      console.log('[Service Worker] Pre-caching static assets');
      // Use map to fetch each resource and handle single failures gracefully
      return Promise.allSettled(
        STATIC_ASSETS.map((asset) => {
          return cache.add(asset).catch((err) => {
            console.warn(`[Service Worker] Failed to pre-cache asset: ${asset}`, err);
          });
        })
      );
    }).then(() => self.skipWaiting())
  );
});

// Activate Event: clean up old caches
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cache) => {
          if (cache !== CACHE_NAME) {
            console.log('[Service Worker] Clearing old cache', cache);
            return caches.delete(cache);
          }
        })
      );
    }).then(() => self.clients.claim())
  );
});

// Fetch Event
self.addEventListener('fetch', (event) => {
  // Only handle GET requests
  if (event.request.method !== 'GET') return;

  const requestUrl = new URL(event.request.url);

  // 1. Handle Google Fonts CDN assets with Cache First (falls back to Network)
  if (event.request.url.startsWith('https://fonts.googleapis.com') || 
      event.request.url.startsWith('https://fonts.gstatic.com')) {
    event.respondWith(
      caches.match(event.request).then((cachedResponse) => {
        if (cachedResponse) return cachedResponse;
        return fetch(event.request).then((networkResponse) => {
          if (networkResponse.status === 200) {
            const cacheCopy = networkResponse.clone();
            caches.open(CACHE_NAME).then((cache) => {
              cache.put(event.request, cacheCopy);
            });
          }
          return networkResponse;
        });
      })
    );
    return;
  }

  // 2. Handle HTML/PHP pages (index.php, lineup.php, map.php, info.php, /)
  const isHtmlPage = event.request.mode === 'navigate' || 
                     requestUrl.pathname.endsWith('.php') || 
                     requestUrl.pathname === '/' || 
                     requestUrl.pathname.endsWith('/');

  if (isHtmlPage) {
    // Network First Strategy
    event.respondWith(
      fetch(event.request)
        .then((networkResponse) => {
          // Cache the fresh HTML response
          if (networkResponse.status === 200) {
            const cacheCopy = networkResponse.clone();
            caches.open(CACHE_NAME).then((cache) => {
              cache.put(event.request, cacheCopy);
            });
          }
          return networkResponse;
        })
        .catch(() => {
          // If offline, check cache for the specific page
          return caches.match(event.request).then((cachedResponse) => {
            if (cachedResponse) return cachedResponse;
            
            // Fallback for pages that aren't cached yet (like root URL /)
            const fallbackPath = requestUrl.pathname.endsWith('lineup.php') ? 'lineup.php' :
                                 requestUrl.pathname.endsWith('map.php') ? 'map.php' :
                                 requestUrl.pathname.endsWith('info.php') ? 'info.php' : 'index.php';
                                 
            return caches.match(fallbackPath).then((matchedFallback) => {
              if (matchedFallback) return matchedFallback;
              
              // Absolute fallback: offline.html page
              return caches.match('offline.html');
            });
          });
        })
    );
    return;
  }

  // 3. Static local files (CSS, JS, Images, SVGs) - Cache First Strategy
  event.respondWith(
    caches.match(event.request).then((cachedResponse) => {
      if (cachedResponse) return cachedResponse;
      
      return fetch(event.request).then((networkResponse) => {
        if (networkResponse.status === 200) {
          const cacheCopy = networkResponse.clone();
          caches.open(CACHE_NAME).then((cache) => {
            cache.put(event.request, cacheCopy);
          });
        }
        return networkResponse;
      }).catch(() => {
        // Silent fail for missing static resources
        return new Response('Offline resource not found', { status: 404 });
      });
    })
  );
});
