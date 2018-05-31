var CACHE_VERSION = '1';                    // PARA CONTROLAR LOS CAMBIOS DE ALGUN FICHERO CACHEADO Y LO DETECTE
var CACHE_NAME    = 'mi-segundo-sw';
var urlsToCache   = [
    //'/js/dibujo.js',
    '/ejemplo.html',
    '/sw-fallback.js',
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
    console.log('asdasda');

    event.respondWith(
        // BUSCA EN EL CACHE
        caches.match(event.request)
            .then(function (response) {

                if (response) {
                    return response; // SI EXISTE ALGO EN CACHE LO DEVUELVE
                }
                console.log('sadas')
                var fetchRequest  = event.request.clone();

                return fetch(fetchRequest).then(function (response) {
                    console.log(response);
                    if (response == undefined || !response.ok) {
                            throw Error('error en fetch');
                    }

                    return response;

                }).catch(function (error) {
                    console.warn('Constructing a fallback response, due to an error while fetching the real response:', error);

                    var newRequest = new Request('http://localhost:8080/ejemplo.html');
                    console.log('casi');
                        // Se devuelve la pagina de error
                    return fetch(newRequest);

                });
            })
    );
});
