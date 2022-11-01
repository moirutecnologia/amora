$(function () {

});

function listarTabela() {
    ajax({
        metodo: 'metodopagamento/carregartabela/text',
        dados: get_para_array(),
        assincrono: true,
        sucesso: function(retorno) {
            $('[js-tabela]').html(retorno);
            $('.is-loading').removeClass('is-loading');
        }
    });
}