$(function () {

    $(document).on('click', '#salvar', function (e) {
        e.preventDefault();
        let elemento = $(this);

        let formulario = $('#formulario');
        formulario.validarFormulario();

        let dados = {};

        dados.nome = formulario.find('#nome').val();
        dados.email = formulario.find('#email').val();
        dados.whatsapp = formulario.find('#whatsapp').val();
        dados.senha = formulario.find('#senha').val();

        elemento.addClass('is-loading');

        ajax({
            metodo: 'usuario/atualizar',
            dados: dados,
            assincrono: true,
            sucesso: function (retorno) {
                elemento.removeClass('is-loading');
            }
        });

    });

});