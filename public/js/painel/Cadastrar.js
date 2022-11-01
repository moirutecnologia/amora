$(function () {

    $(document).on('click', '#salvar', function (e) {
        e.preventDefault();
        let elemento = $(this);

        let formulario = $('#formulario-login');
        formulario.validarFormulario();

        let dados = {};

        dados.nome = formulario.find('#nome').val();
        dados.email = formulario.find('#email').val();
        dados.whatsapp = formulario.find('#whatsapp').val();
        dados.senha = formulario.find('#senha').val();

        elemento.addClass('is-loading');

        ajax({
            metodo: 'usuario/cadastrar',
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

});