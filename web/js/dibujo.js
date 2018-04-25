var canvas;

function circulo (options, config = []) {
    config = configuracion();
    var circle = new fabric.Circle({
      radius: config.radius,
      fill: config.fill,
      left: options.e.layerX,
      top: options.e.layerY
    });

    return circle;
}

function cruz (options,config = []) {
    config = configuracion();
    var triangle = new fabric.Triangle({
        width: config.width,
        height: config.height,
        fill: config.fill,
        left: options.e.layerX,
        top: options.e.layerY,
    });

    return triangle;
}

function cuadrado(options, config = []) {
    config = configuracion();
    var cuadrado = new fabric.Rect({
        top: options.e.layerY,
        left: options.e.layerX,
        width : config.width,
        fill: config.fill,
    });
    //cuadrado.width = config.width;
    cuadrado.height = config.height;
    return cuadrado;
}

function crearLienzo(id) {
    canvas = new fabric.Canvas(id,{
       width: 500, height: 500,
    });
    // "add" rectangle onto canvas
    // canvas.add(rect).setActiveObject;
    // canvas.isDrawingMode= true;
    var imgElement = document.getElementById('futbol');
    var imgInstance = new fabric.Image(imgElement);
    canvas.add(imgInstance);
    canvas.centerObject(imgInstance);
    imgInstance.set('selectable', false);
    colocarBotones(id);
    canvas.on('mouse:dblclick', eventos);
}

function colocarBotones(id) {
    var canvas = $('#' + id);
    var botones = ['Circulo','Cuadrado','Cruz'];
    var div = $('.figura');

    for (var i = 0; i < botones.length; i++) {
        var boton = $('<input>');
        var label = $('<label>');
        label.text(botones[i]);
        label.attr('for',botones[i]);
        boton.attr('type','radio');
        boton.attr('name', 'figura');
        boton.attr('id', botones[i]);
        boton.attr('data-figura', botones[i].toLowerCase());
        div.append(label);
        div.append(boton);
        div.append($('<br>'));
        /*boton.on('change',function(){
            //entonces db debe cambiar
            eventos($(this).data('figura'));
        })*/
    }

}

function eventos (options){
    var figura = figuras();
    objecto = circulo(options);
    switch (figura) {
        case 'circulo':
            objecto = circulo(options);
        break;
        case 'cuadrado':
            objecto = cuadrado(options);
        break;
        case 'cruz':
            objecto = cruz(options);
        break;
    }

    canvas.add(objecto).setActiveObject();
}

function figuras() {
    return $('input[name="figura"]:checked').data('figura');
}

function configuracion()
{
    return {
            width:100,
            height:100,
            fill:'green',
            radius:20,
    };
}

$('#posts-form').on('beforeValidate', function (e) {
    $('#posts-canvas').val(canvas.toDataURL());

});

$(function() {
    $('input[type="radio"]').checkboxradio();
});


crearLienzo('myCanvas');
