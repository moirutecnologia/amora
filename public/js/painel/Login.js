$(function () {

    $(document).on('click', '#entrar', function (e) {
        e.preventDefault();
        let elemento = $(this);

        let formulario = $('#formulario-login');
        formulario.validarFormulario();

        let dados = {};

        dados.email = formulario.find('#email').val();
        dados.senha = formulario.find('#senha').val();

        elemento.addClass('is-loading');

        ajax({
            metodo: 'usuario/login',
            dados: dados,
            assincrono: true,
            sucesso: function (retorno) {
                if (retorno.resultado == 1) {
                    let retorno = pegarParametroUrl('retorno');
                    if(retorno == null || retorno == ''){
                        retorno = '/painel';
                    }

                    document.location.href = retorno;
                } else {
                    elemento.removeClass('is-loading');
                }
            }
        });

    });

    $(document).on('click', '#esqueceu-senha small', function (e) {
        e.preventDefault();
        let elemento = $(this);

        let formulario = $('#formulario-login');
        let email = formulario.find('#email');
        email.removeClass('is-danger');

        let dados = {};

        dados.email = email.val();

        if (dados.email == '') {
            email.addClass('is-danger').focus();
            return false;
        }

        elemento.html('Aguarde...');

        ajax({
            metodo: 'usuario/novasenha',
            dados: dados,
            assincrono: true,
            sucesso: function (retorno) {
                elemento.html('Esqueceu a senha?');
            }
        });

    });

});