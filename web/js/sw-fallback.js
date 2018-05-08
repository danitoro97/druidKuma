var CACHE_VERSION = '1';                    // PARA CONTROLAR LOS CAMBIOS DE ALGUN FICHERO CACHEADO Y LO DETECTE
var CACHE_NAME    = 'mi-segundo-sw';
var urlsToCache   = [
    '/js/dibujo.js',
    '/ejemplo.html',
    '/js/sw-fallback.js',
];

self.addEventListener('install', function (event) {
    // event.waitUntil -> TOMA UNA PROMESA Y LA USA PARA SABER CUANTO TIEMPO TARDA LA
    //                    INSTALACION Y SI SE REALIZO CORRECTAMENTE
    event.waitUntil(
        caches.open(CACHE_NAME)
        .then(function (cache) {
            console.log('Abriendo cache. Version: ' + CACHE_VERSION);
            return cache.addAll(urlsToCache)        // Anadiendo archivos
                   .then(() => self.skipWaiting()); // Saltar cuando se encuentre actualizaciones
        })
    );
});

// CONTROLA LAS PETICIONES CACHEADAS EN PRIMER LUGAR
self.addEventListener('fetch', function(event) {
    var URL_COMPROBAR = 'http://localhost/ServiceWorker/con-conexion.html';
    var FALLBACK_URL  = 'http://localhost:8080/ejemplo.html';

    event.respondWith(
        // BUSCA EN EL CACHE
        caches.match(event.request)
            .then(function (response) {
                if (response) {
                    return response; // SI EXISTE ALGO EN CACHE LO DEVUELVE
                }

                var fetchRequest  = event.request.clone();

                return fetch(fetchRequest).then(function (response) {
                    if (response == undefined || !response.ok) {
                        //if (fetchRequest.url == URL_COMPROBAR) {
                            throw Error('error en fetch');
                        //}
                    }

                    return response;

                }).catch(function (error) {
                    console.warn('Constructing a fallback response, due to an error while fetching the real response:', error);

                    if (fetchRequest.url == URL_COMPROBAR) {
                        var newRequest = new Request(FALLBACK_URL);

                        // Se devuelve la pagina de error
                        return fetch(newRequest);
                    }

                    // Se devuelve la peticion al recurso solicitado
                    return fetch(fetchRequest);
                });
            })
    );
});

// BORRA EL CACHE ANTERIOR DETECTANDO CAMBIOS CUANDO SE ACTIVA
self.addEventListener('activate', function (event) {
    var cacheWhitelist = [CACHE_NAME];

    // CUANDO SE ENCUENTRA EN ESPERA UN NUEVO FICHERO
    event.waitUntil(
        caches.keys().then(function (cacheNames) {
            return Promise.all(
                cacheNames.map(function (cacheName) {
                    if (cacheWhitelist.indexOf(cacheName) === -1) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});
