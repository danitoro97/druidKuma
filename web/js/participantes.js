$('#mas').on('click', function(){
    var elemento = $('#w0 >div').first();
    console.log(elemento);
    var a = elemento.clone();
    $(elemento).after(a);
});
