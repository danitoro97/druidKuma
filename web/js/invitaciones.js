function aceptar (data,div) {
    console.log('aceptar');
    div.remove();
    var div = $('<div>');
    div.html(data);
    $('.equipos-usuarios-index').append(div);
}

function rechazar (div){
    $(div).remove();
}
