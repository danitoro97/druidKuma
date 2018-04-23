/*canvas.on('mouse:dblclick', function(options) {
   //console.log(options);

});*/
/*  fabric.log('', canvas.toDataURL({
       format: 'png',
}));*/
//console.log(canvas.toDataURL({format:'png'}))
var canvas;
function circulo (options) {
    var circle = new fabric.Circle({
      radius: 20, fill: 'green', left: options.e.layerX, top: options.e.layerY
    });
    //var circle = new fabric.Line([10,10]);
    canvas.add(circle);
}

function cruz (options) {
    var triangle = new fabric.Triangle({
        width: 20, height: 30, fill: 'blue', left: 50, top: 50
    });
    //var circle = new fabric.Line([10,10]);
    canvas.add(triangle);
}

function cuadrado(options) {
    var cuadrado = new fabric.Rect({ top: 100, left: 100, width: 50, height: 50, fill: '#f55' });
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
        var boton = $('<button>');
        boton.text(botones[i]);
        boton.attr('data-figura', botones[i].toLowerCase());
        div.append(boton);
        boton.on('click',function(){
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
            canvas.on('mouse:dblclick',cuadrado);
        break;
        case 'cruz':
            canvas.on('mouse:dblclick',cruz);
        break;
    }
}

crearLienzo('myCanvas');
