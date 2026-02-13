self.addEventListener("install", function (event) {
    console.log("[Service Worker] Installing Service Worker ...", event);
    event.waitUntil(
        caches.open("static").then(function (cache) {
            console.log("[Service Worker] Precaching App Shell");
            cache.addAll([
                "/",
                "/assets/coreui/css/style.css",
                "/assets/coreui/js/coreui.bundle.min.js",
                "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css",
                "https://unpkg.com/leaflet@1.9.4/dist/leaflet.css",
                "https://unpkg.com/leaflet@1.9.4/dist/leaflet.js",
                "https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js",
            ]);
        }),
    );
});

self.addEventListener("activate", function (event) {
    console.log("[Service Worker] Activating Service Worker ...", event);
    return self.clients.claim();
});

self.addEventListener("fetch", function (event) {
    // Simple Cache-First Strategy
    // event.respondWith(
    //     caches.match(event.request).then(function(response) {
    //         if (response) {
    //             return response;
    //         } else {
    //             return fetch(event.request);
    //         }
    //     })
    // );
    // Commented out to prevent caching issues during dev.
    // Usually strict Network-first is safer for dynamic apps.
});
