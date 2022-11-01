<?php

$parametros['aguardando_entrega'] = 1;
$parametros['ordem'] = 'c.nome, p.nome, vp.quantidade';
$aguardandoentregas = \controller\Entrega::_listar($parametros);
$cliente = '';

?>
<?php if (!empty($aguardandoentregas)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Produto</div>
                <div class="column">Quantidade</div>
                <div class="column">Preço</div>
                <div class="column is-2 has-text-centered">Ações</div>
            </div>
        </div>

        <?php
        $total = 0;
        foreach ($aguardandoentregas as $indice => $aguardandoentrega) {
            $total += $aguardandoentrega->preco * $aguardandoentrega->quantidade;
            ?>
            <?php
            if ($cliente != $aguardandoentrega->cliente) {
                $cliente = $aguardandoentrega->cliente;
            ?>
                <div class="column is-12 grupo">
                    <span><?php echo $aguardandoentrega->cliente; ?></span>
                </div>
            <?php
            } // if $cliente != $aguardandoentrega->cliente
            ?>
            <div class="column is-12 linha" js-produto produto_id="<?php echo $aguardandoentrega->produto_id; ?>" quantidade="<?php echo $aguardandoentrega->quantidade; ?>" vendaproduto_id="<?php echo $aguardandoentrega->vendaproduto_id; ?>">
                <div class="columns is-vcentered">
                    <div class="column" label="Produto"><?php echo $aguardandoentrega->produto; ?></div>
                    <div class="column" label="Quantidade"><?php echo $aguardandoentrega->quantidade; ?></div>
                    <div class="column" label="Preço">R$ <?php echo mask($aguardandoentrega->preco, '$'); ?></div>
                    <div class="column is-2 has-text-centered acoes" label="Ações">
                        <div class="columns is-mobile is-vcentered">
                            <div class="column is-1-desktop">
                                <a href="#confirmar-<?php echo $aguardandoentrega->vendaproduto_id; ?>" data-fancybox title="Excluir">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                                <div id="confirmar-<?php echo $aguardandoentrega->vendaproduto_id; ?>" style="display: none;">
                                    <h3 class="subtitle">Confirma a exclusão de <?php echo $aguardandoentrega->produto; ?>?</h3><br>
                                    <div class="buttons is-centered">
                                        <button class="button is-link is-secondary" data-fancybox-close>
                                            Cancelar
                                        </button>
                                        <button class="button is-danger" js-excluir="<?php echo $aguardandoentrega->vendaproduto_id; ?>" controller="vendaproduto">
                                            <span class="icon">
                                                <i class="far fa-trash-alt"></i>
                                            </span>
                                            <span>Excluir</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="select is-fullwidth">
                                    <select id="entregue" produto_id="<?php echo $aguardandoentrega->produto_id; ?>" cliente_id="<?php echo $aguardandoentrega->cliente_id; ?>" preco="<?php echo $aguardandoentrega->preco; ?>" quantidade="<?php echo $aguardandoentrega->quantidade; ?>">
                                        <?php
                                        $parametros['produto_id'] = $aguardandoentrega->produto_id;
                                        $parametros['aguardadoentrega'] = 1;
                                        include '../view/painel/includes/produtoskus-opcoes-venda.php';
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($aguardandoentregas[$indice + 1]->cliente != $aguardandoentrega->cliente) { ?>
                <div class="column is-12 linha rodape">
                    <div class="columns is-vcentered is-mobile">
                        <div class="column"><strong>Entrega: R$ <span js-total cliente_id="<?php echo $aguardandoentrega->cliente_id; ?>">0,00</span></strong></div>
                        <div class="column has-text-right"><button id="confirmar-entrega" class="button is-primary" cliente_id="<?php echo $aguardandoentrega->cliente_id; ?>" disabled>Confirmar</button></div>
                    </div>
                </div>
            <?php } // $aguardandoentrega[$indice + 1]->cliente != $aguardandoentrega[$indice + 1]->cliente 
            ?>
        <?php } // foreach $aguardandoentregas 
        ?>
        <div class="column is-12 linha rodape">
            Total aguardando entrega: R$ <?php echo mask($total, '$'); ?>
        </div>
    </div>
<?php } else { ?>
    <div class="sem-registro">
        Nada para exibir<br />
    </div>
<?php } // if !empty $aguardandoentregas 
?>