function aa(boton,ruta,id) {
    $(boton).on('click',function(event) {
        var textarea = $(this).next();
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
                    $(this).remove();
                    /*var boton = $('button');
                    boton.text('Responder');
                    boton.addClass('btn btn-xs btn-info responder');
                    console.log(div);*/
                }
            })
        }

    });
}
