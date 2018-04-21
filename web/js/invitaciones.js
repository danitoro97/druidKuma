function aceptar (data,div) {

    div.remove();
    var div = $('<div>');
    div.html(data);
    $('.equipos-usuarios-index').find('.container').append(div);
}

function rechazar (div){
    $(div).remove();
}
