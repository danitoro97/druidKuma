var CACHE_VERSION = '1';                    // PARA CONTROLAR LOS CAMBIOS DE ALGUN FICHERO CACHEADO Y LO DETECTE
var CACHE_NAME    = 'mi-segundo-sw';
var urlsToCache   = [
    '/js/dibujo.js',
    '/js/sw-fallback.js',
    '/css/fonts/AllerDisplay.ttf'
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
