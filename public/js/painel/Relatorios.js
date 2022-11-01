$(function () {

    $(document).on('change', '#relatorio', function (e) {
        e.preventDefault();

        removerGet('tipo');

        let elemento = $(this);

        let opcoes = [];

        if (elemento.val() == 'cliente') {
            opcoes.push({
                'chave': 'extrato',
                'valor': 'Extrato',
                'filtros' : 'clientes,data-de,data-ate'
            });

            opcoes.push({
                'chave': 'intervalo-compra',
                'valor': 'Intervalo de compra',
                'filtros' : 'clientes,data-de,data-ate'
            });

            opcoes.push({
                'chave': 'intervalo-compra-produto',
                'valor': 'Intervalo de compra de produto',
                'filtros' : 'clientes,data-de,data-ate'
            });

            opcoes.push({
                'chave': 'melhores',
                'valor': 'Melhores',
                'filtros' : 'clientes,data-de,data-ate'
            });

            opcoes.push({
                'chave': 'mes',
                'valor': 'Mês',
                'filtros' : 'clientes,data-de,data-ate'
            });

            opcoes.push({
                'chave': 'produtos-comprados',
                'valor': 'Produtos comprados',
                'filtros' : 'clientes,data-de,data-ate'
            });

            opcoes.push({
                'chave': 'total',
                'valor': 'Total',
                'filtros' : 'clientes'
            });


        } else if (elemento.val() == 'marca') {
            opcoes.push({
                'chave': 'detalhado',
                'valor': 'Detalhado',
                'filtros' : 'data-de,data-ate,marcas'
            });

            opcoes.push({
                'chave': 'mes',
                'valor': 'Mês',
                'filtros' : 'data-de,data-ate,marcas'
            });

            opcoes.push({
                'chave': 'total',
                'valor': 'Total',
                'filtros' : 'data-de,data-ate,marcas'
            });

            opcoes.push({
                'chave': 'vendidos-sem-estoque',
                'valor': 'Aguardando entrega sem estoque',
                'filtros': 'marcas'
            });

        } else if (elemento.val() == 'investimento') {
            opcoes.push({
                'chave': 'mes-detalhado',
                'valor': 'Detalhado',
                'filtros' : 'data-de,data-ate,investimentos-tipos'
            });

            opcoes.push({
                'chave': 'mes',
                'valor': 'Mês',
                'filtros' : 'data-de,data-ate,investimentos-tipos'
            });

            opcoes.push({
                'chave': 'total',
                'valor': 'Total',
                'filtros' : 'data-de,data-ate,investimentos-tipos'
            });
        } else if (elemento.val() == 'metodopagamento') {
            opcoes.push({
                'chave': 'mes',
                'valor': 'Mês',
                'filtros' : 'data-de,data-ate,metodos-pagamentos'
            });

            opcoes.push({
                'chave': 'mes-detalhado',
                'valor': 'Mês detalhado',
                'filtros' : 'data-de,data-ate,metodos-pagamentos'
            });

            opcoes.push({
                'chave': 'total',
                'valor': 'Total',
                'filtros' : 'data-de,data-ate,metodos-pagamentos'
            });
        }

        $('#tipo').html(`<option value="">Selecione o relatório</option>`);
        setarGet('relatorio', elemento.val());

        if (opcoes.length > 0) {
            $('#tipo').html('');
            $.each(opcoes, function () {
                $('#tipo').append(`<option value="${this.chave}" filtros="${this.filtros}">${this.valor}</option>`);
            });

            $('#tipo').val('total').change();
        }

    });

    $(document).on('change', '#tipo', function (e) {
        let filtros = $(this).find(':selected').attr('filtros');
        
        $('[js-filtro]').hide();

        if(filtros != 'undefined'){
            filtros = filtros.split(',');
            $.each(filtros, function(){
                $(`[js-filtro="${this}"]`).show();
            });
        }
    });

    if(pegarParametroUrl('relatorio') != null){
        listarTabela();
    }

});

function listarTabela() {
    ajax({
        metodo: 'relatorio/carregartabela/text',
        dados: get_para_array(),
        assincrono: true,
        sucesso: function (retorno) {
            $('[js-tabela]').html(retorno);
            $('.is-loading').removeClass('is-loading');
        }
    });
}