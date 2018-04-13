$('#next').on('click', function (){

    var li = $('.carousel-indicators li').last().prev();

    if (li.hasClass('active')) {
        console.log('ajax');
        var numeroJugadores = $('.carousel-indicators li').length;

        $.get(ruta, {numero:numeroJugadores}, function(data){

        });

    }

})
