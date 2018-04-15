

function carrousel (ruta, id) {
    console.log(ruta);
    $('#next').on('click',{ruta:ruta, id:id}, function (event){
        var ruta = event.data.ruta;
        var id = event.data.id;

        var div = $('.carousel-inner > div').last().prev();

        if (div.hasClass('active')) {
            $('#myCarousel').carousel('pause');

            //div.removeClass('active');

            console.log('ajax');
            var numeroJugadores = $('.carousel-inner > div').length;

            $.get(ruta, {numero:numeroJugadores,id:id}, function(data){
                var urlDefault = data.url;

                for (var i = 0; i < 3; i++) {
                    var div = $('<div>');
                    div.addClass('item');
                    var img = $('<img></img>');
                    if (data[i].url == null) {
                        data[i].url = urlDefault;
                    }
                    img.attr('src', data[i].url);
                    div.append(img);
                    var info = $('<div>');
                    info.addClass('carousel-caption');
                    var h3 = $('<h3>');
                    var h4 = $('<h4>');
                    h3.text(data[i].nombre);
                    h4.text('Dorsal ' + data[i].dorsal);
                    info.append(h3);
                    info.append(h4);
                    div.append(info);

                    var li = $('<li>');
                    li.attr('data-target','#myCarousel');
                    li.attr('data-slide-to', ++numeroJugadores);

                    $('.carousel-inner').append(div);

                    $('.carousel-indicators').append(li);
                }


            });

        }

    })
}
