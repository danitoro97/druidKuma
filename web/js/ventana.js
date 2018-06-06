function comentado(ruta) {
    var elemento = $("a[href$="+ruta +"]");
    console.log(elemento)
    elemento.removeClass('visto');
    elemento.addClass('comentado');
}
