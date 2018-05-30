var canvas;

function downColor (options){
    canvas.freeDrawingBrush.color = color();
}

function circulo (options, config = []) {
    config = configuracion();
    return new fabric.Circle({
      radius: config.radius,
      fill: config.fill,
      left: options.e.layerX,
      top: options.e.layerY,
      originX: 'center',
      originY: 'center',
    });

}

function cruz (options,config = []) {
    config = configuracion();
    return new fabric.Triangle({
        width: config.width,
        height: config.height,
        fill: config.fill,
        originX: 'center',
        originY: 'center',
        top: options.e.layerY,
        left: options.e.layerX,
    });

}

function cuadrado(options, config = []) {
    config = configuracion();

    return new fabric.Rect({
        top: options.e.layerY,
        left: options.e.layerX,
        width : config.width,
        fill: config.fill,
        originX: 'center',
        originY: 'center',
        height :config.height


    });

}

function xa(options, config = []) {
    config = configuracion();

    var line= new fabric.Line([50, 100, 100, 150],{

     stroke: config.fill,
     strokeWidth: 5,
     width: config.width,
     height: config.height,
     top: options.e.layerY,
     left: options.e.layerX,
    // selectable: false
   });
   var line2= new fabric.Line([150, 100, 100, 150],{

    stroke: config.fill,
    strokeWidth: 5,
    width: config.width,
    height: config.height,
    top: options.e.layerY,
    left: options.e.layerX,
   // selectable: false
  });

  return new fabric.Group([ line, line2 ]);
}

function crearLienzo(id) {
    canvas = new fabric.Canvas(id,{
        height:500,
        width:500,
    });
    fabric.util.addListener(fabric.document, 'keypress',eliminar);
}

function eliminar(event) {
    var code = event.keyCode || event.which;
    //supr 46 delete 8 supr chrome 127
    if (code == '46' || code =='8' || code == '127') {
        var objecto = canvas.getActiveObject();
        if (objecto != undefined) {
            canvas.remove(objecto);
        }

    }
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
    });



}

function colocarBotones() {
    var botones = ['Circulo','Cuadrado','Cruz','X'];
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
        case 'x':
            objecto = xa(options);
        break;
    }
    canvas.add(objecto);
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
            var dato = $(this).val();

            if (!isNaN(dato)) {
                dato = parseInt($(this).val());
            }
            config[data] = dato;
        }

    });

    console.log($.extend(predefinido,config))
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
        dialog.prompt({
			title: "Texto a añadir",
			button: "Insertar",
			required: false,
			position: "absolute",
			animation: "slide",
			input: {
				type: "text",

			},
			callback: function(value){
				var text = new fabric.Text(value);
                canvas.add(text);
			}
		});
        return false;
    });
}

$('#posts-form').on('beforeValidate', function (e) {
    $('#posts-canvas').val(canvas.toDataURL({'format':'png'}));
});

$(function() {
    $('input[type="radio"]').checkboxradio();
});


crearLienzo('myCanvas');
colocarBotones();
botonesConfiguracion();
fabric.util.addListener(fabric.document, 'touchmove',function(){
    canvas.isDrawingMode= true;
    canvas.freeDrawingBrush.width = 10;
});
canvas.on('mouse:dblclick', eventos);
canvas.on('mouse:down', downColor);
canvas.hoverCursor = 'pointer';


function myFunction(x) {
    if (x.matches) { // If media query matches
        $('.figura').hide();
        $('.configuracion').hide();
        //$('#libre').prop('checked',true);
        $('#libre').trigger('click');
    } else {
        $('.figura').show();
        $('.configuracion').show();
    }
}

var x = window.matchMedia("(max-width: 700px)")
myFunction(x) // Call listener function at run time
x.addListener(myFunction) // Attach listener function on state changes
