$(function () {

    $(document).on('change', '#entregue', function (e) {
        let elemento = $(this);
        let span = $('[js-total][cliente_id="' + elemento.attr('cliente_id') + '"]');

        let valor = 0;
        let habilitar = false;

        $.each($('select[cliente_id="' + elemento.attr('cliente_id') + '"] :selected'), function () {
            let entrega = $(this);
            let select = entrega.closest('select');

            if (entrega.attr('preco') != undefined) {
                habilitar = true;
                valor += parseInt(select.attr('quantidade')) * parseFloat(select.attr('preco'));
            }
        });

        span.html(valor.toReal());

        if (habilitar) {
            $('#confirmar-entrega[cliente_id="' + elemento.attr('cliente_id') + '"]').removeAttr('disabled');
        } else {
            $('#confirmar-entrega[cliente_id="' + elemento.attr('cliente_id') + '"]').attr('disabled', '');
        }
    });

    $(document).on('click', '#confirmar-entrega', function (e) {
        let elemento = $(this);
        let cliente_id = elemento.attr('cliente_id');

        let produtos = [];

        $.each($('select[cliente_id="' + cliente_id + '"] :selected'), function () {
            let entrega = $(this);
            let produto = entrega.closest('[js-produto]');

            if (entrega.attr('preco') != undefined) {
                let produto_entregue = {};
                produto_entregue.produto_id = produto.attr('produto_id');
                produto_entregue.entregue = entrega.attr('entregue');
                produto_entregue.produtosku_id = entrega.attr('produtosku_id');
                produto_entregue.preco = entrega.attr('preco');
                produto_entregue.quantidade = produto.attr('quantidade');
                produto_entregue.vendaproduto_id = produto.attr('vendaproduto_id');

                produtos.push(produto_entregue);
            }
        });

        let dados = {};
        dados.produtos = produtos;

        elemento.addClass('is-loading');

        ajax({
            metodo: 'entrega/criar',
            dados: dados,
            assincrono: true,
            sucesso: function (retorno) {
                elemento.removeClass('is-loading');
                listarTabela();
            }
        });

    });

});

function listarTabela() {
    ajax({
        metodo: 'entrega/carregartabela/text',
        dados: get_para_array(),
        assincrono: true,
        sucesso: function (retorno) {
            $('[js-tabela]').html(retorno);
            $('.is-loading').removeClass('is-loading');
        }
    });
}