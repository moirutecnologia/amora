<?php if (!empty($parametros['produtos'])) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Nome</div>
                <div class="column">Entregue</div>
                <div class="column">Preço</div>
                <div class="column">Quantidade</div>
                <div class="column is-1 has-text-centered">Ações</div>
            </div>
        </div>

        <?php
        $parametros['produtos'] = (object)$parametros['produtos'];

        $total = 0;
        $ganho = 0;

        foreach ($parametros['produtos'] as $produto_pedido) {
            $produto_pedido = (object)$produto_pedido;
            $produto = \controller\Produto::_obter($produto_pedido->produto_id);
            $marca = \controller\Marca::_obter($produto->marca_id);

            if (!empty($produto_pedido->produtosku_id)) {
                $produtosku = \controller\ProdutoSKU::_obter($produto_pedido->produtosku_id);
                $ganho += ($produto_pedido->preco - $produtosku->preco) * $produto_pedido->quantidade;
            } else {
                $ganho += (($produto->preco * ($marca->comissao / 100)) - ($produto->preco - $produto_pedido->preco)) * $produto_pedido->quantidade;
            }

            $total += $produto_pedido->preco * $produto_pedido->quantidade;
        ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered">
                    <div class="column" label="Nome"><?php echo $produto->nome; ?></div>
                    <div class="column" label="Nome"><?php echo $produto_pedido->entregue ? 'Sim' : 'Não'; ?></div>
                    <div class="column" label="Comissão">R$ <?php echo mask($produto_pedido->preco, '$'); ?></div>
                    <div class="column" label="Comissão"><?php echo $produto_pedido->quantidade; ?></div>
                    <div class="column is-1 has-text-centered acoes" label="Ações">
                        <div class="columns is-mobile">
                            <div class="column">
                                <a href="#" js-remover title="Excluir">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        } // foreach $produtos 
        ?>
    </div>

    <hr />

    <div class="columns is-centered has-text-centered resumo-venda">
        <div class="column is-2">
            <h3 class="subtitle is-7">Total da venda</h3>
            <h2 class="title is-4">R$ <?php echo mask($total, '$'); ?></h2>
        </div>
        <div class="column is-2">
            <p class="heading">Previsão de ganho <strong>(<span js-previsao><?php echo intval(($ganho * 100) / $total); ?></span>%)</strong></p>
            <p class="title is-4" js-ganho="<?php echo mask($ganho, '$'); ?>">R$ <?php echo mask($ganho, '$'); ?></p>
        </div>
    </div>

    <hr />
<?php } else { ?>
    <div class="sem-registro">
        Adicione produtos ao pedido
    </div>
<?php } // if !empty $produtos 
?>