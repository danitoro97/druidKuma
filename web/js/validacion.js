$('#usuarios-form').on('submit',function(){
    var email = $('#usuarios-email');
    var emailValor = email.val();
    var patron = /^.+@[a-z]+[\.][a-z]{2,3}$/;
    var help = email.parent().find('.help-block');
    help.hide();
    if (!patron.test(emailValor)) {
        if (help.next().attr('id') != 'errorEmail') {

            var p = $('<p>');
            p.attr('id','errorEmail');
            p.text('El correo no cumple los requisitos XXX@zzz.ccc');
            p.addClass('error')
            help.after(p);
        }
        return false;
    } else {
        $('#errorEmail').remove();
    }
});
