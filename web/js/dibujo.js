var canvas;

function downColor (options){
    canvas.freeDrawingBrush.color = color();
}

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
    colocarBotones();
    botonesConfiguracion();
    canvas.on('mouse:dblclick', eventos);
    canvas.on('mouse:down', downColor);
}

function modoLibre(div)
{
    var input = $('<input>');
    var label = $('<label>');
    label.text('Modo libre');
    label.attr('for','libre');
    input.attr('type','checkbox');
    input.attr('id','libre');
    input.attr('name','libre');
    div.append(label);
    label.append(input);
    input.on('click',function(){
        if ($(this).prop('checked')) {
            canvas.isDrawingMode= true;
            canvas.freeDrawingBrush.width = 20;
            canvas.freeDrawingBrush.color = color();

        }
        else {
            canvas.isDrawingMode= false;

        }
    })

}

function colocarBotones() {
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
    modoLibre(div);
    insertarTexto(div);
}

function botonesConfiguracion (){
    var div = $('.configuracion');

    var propiedades = ['width','height','radius','fill'];
    var plabel = ['ancho','alto','radio','color'];
    for (var i = 0; i < propiedades.length; i++) {
        var label = $('<label>');
        label.text(plabel[i]);
        var boton = $('<input>');
        boton.attr('type','number');
        if (propiedades[i] == 'fill') {
            boton.attr('type','color');
        }
        boton.attr('data-configuracion', propiedades[i]);
        div.append(label);
        div.append(boton);
    }


}

function eventos (options){
    var figura = figuras();


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
    var predefinido = {
        width:50,
        height:50,
        fill:color(),
        radius:5,
    };
    var config = {};
    var input = $('.configuracion').find('input');

    input.each(function(i,elemento){
        var data = $(this).data('configuracion');
        if ($(this).val() != '') {
            config[data] = $(this).val();
        }


    });

    return $.extend(predefinido,config);
}

function color()
{
    return $('input[type="color"]').val();
}

function insertarTexto(div) {
    var boton = $('<button>');
    boton.attr('id','texto');
    boton.text('insertar texto');
    div.append(boton);
    boton.on('click',function(){
        var text = new fabric.Text(prompt('Introduzca el texto'));
        canvas.add(text);
    });
}

$('#posts-form').on('beforeValidate', function (e) {
    $('#posts-canvas').val(canvas.toDataURL());

});

$(function() {
    $('input[type="radio"]').checkboxradio();

});


crearLienzo('myCanvas');
