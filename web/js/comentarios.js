function comentar(boton,ruta,id) {
    $(boton).on('click',function(event) {
        var textarea = $(this).next();
        var enviar = $(this);
        var mensaje = textarea.val();
        var padre = $(this).parent().data('padre_id');
        var div = $(this).parent();
        console.log(padre);
        console.log('enviar')
        if (mensaje != '') {
            //peticion ajax
            $.ajax({
                url:ruta,
                type:'post',
                data: {
                    padre_id: padre ,
                    noticia: id,
                    comentario: mensaje
                },
                success: function (data) {
                    console.log('enviado')
                    var div2 = $('<div>');
                    div2.html(data);
                    console.log(div);
                    div.after(div2);

                    textarea.remove();
                    enviar.remove();
                    var nboton = $('<button></button>');

                    nboton.text('Responder');
                    nboton.addClass('btn btn-xs btn-info responder');
                    nboton.on('click',function(){
                        $(this).after($('<textarea>'));
                        var boton = $('<button>');
                        boton.text('Enviar');
                        boton.addClass('btn btn-xs btn-info enviar');

                        comentar(boton,ruta,id);

                        $(this).after(boton);
                        $(this).remove();
                    });
                    div.append(nboton);

                }
            })
        }

    });
}
