$('#mas').on('click', function(event){
    var elemento = $('#participantes-usuario_id').first();
    console.log(elemento);
    var a = elemento.clone();
    a.val(null);
    a.attr('id',null);
    $(elemento).after(a);
    event.preventDefault();
});
