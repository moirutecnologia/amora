$(function () {
    $(document).on('click', '[js-devolver]', function(e){
        e.preventDefault();
        let elemento = $(this);
        
        let dados = {};
        dados.vendaproduto_id = elemento.attr('js-devolver');

        console.log(dados);

        ajax({
            metodo: 'entrega/devolver',
            dados: dados,
            assincrono: true,
            sucesso: function (retorno) {
                listarTabela();
                $.fancybox.close();
            }
        });
    });

    $('#entregue_de').change();
});

function listarTabela() {
    ajax({
        metodo: 'entrega/carregartabelaentregas/text',
        dados: get_para_array(),
        assincrono: true,
        sucesso: function (retorno) {
            $('[js-tabela]').html(retorno);
            $('.is-loading').removeClass('is-loading');
        }
    });
}