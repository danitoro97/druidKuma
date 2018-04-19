function aceptar (data,div) {
    
    div.remove();
    var div = $('<div>');
    div.html(data);
    $('.equipos-usuarios-index').append(div);
}

function rechazar (div){
    $(div).remove();
}
