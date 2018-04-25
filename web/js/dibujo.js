/*canvas.on('mouse:dblclick', function(options) {
   //console.log(options);

});*/
/*  fabric.log('', canvas.toDataURL({
       format: 'png',
}));*/
//console.log(canvas.toDataURL({format:'png'}))
var canvas;
function circulo (options, config = []) {
    config = configuracion();
    var circle = new fabric.Circle({
      radius: config.radius,
      fill: config.fill,
      left: options.e.layerX,
      top: options.e.layerY
    });
    //var circle = new fabric.Line([10,10]);
    canvas.add(circle);
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
    //var circle = new fabric.Line([10,10]);
    canvas.add(triangle);
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
    canvas.add(cuadrado);
}

function crearLienzo(id) {
    canvas = new fabric.Canvas(id,{
       width: 500, height: 500,
    });
    // console.log(canvas);
           // create a rectangle object
    /*var rect = new fabric.Rect({
       left: 100,
       top: 100,
       fill: 'red',
       width: 20,
       height: 20
    });*/

    // "add" rectangle onto canvas
    // canvas.add(rect).setActiveObject;
    // canvas.isDrawingMode= true;
    var imgElement = document.getElementById('futbol');
    var imgInstance = new fabric.Image(imgElement);
    canvas.add(imgInstance);
    imgInstance.set('selectable', false);
    colocarBotones(id);
}

function colocarBotones(id) {
    var canvas = $('#' + id);
    var botones = ['Circulo','Cuadrado','Cruz'];
    var div = canvas.parent().parent().parent();

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
        boton.on('change',function(){
            //entonces db debe cambiar
            eventos($(this).data('figura'));
        })
    }

}

function eventos (figura){
    console.log(figura);
    canvas.off();
    switch (figura) {
        case 'circulo':
            //canvas.on('mouse:dblclick',circulo);
            canvas.on('mouse:dblclick', circulo);
        break;
        case 'cuadrado':
            canvas.on('mouse:dblclick',function(e){
                cuadrado(e,{width:100,height:200,fill:'black'});
            });
        break;
        case 'cruz':
            canvas.on('mouse:dblclick',cruz);
        break;
    }
}

crearLienzo('myCanvas');

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
