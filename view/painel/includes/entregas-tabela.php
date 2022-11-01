<?php

$parametros['entregue'] = 1;
$parametros['ordem'] = 'c.nome, vpe.entrega_id, p.nome, vp.quantidade';
$entregas = \controller\Entrega::_listar($parametros);
$cliente = '';
$data = '';

?>
<?php if (!empty($entregas)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Produto</div>
                <div class="column">Quantidade</div>
                <div class="column">Preço</div>
                <div class="column is-1 has-text-centered">Ações</div>
            </div>
        </div>

        <?php
        $total = 0;
        $total_entrega = 0;
        foreach ($entregas as $indice => $entrega) {
            $total += $entrega->preco * $entrega->quantidade;
            $total_entrega += $entrega->preco * $entrega->quantidade;
        ?>
            <?php
            if ($cliente != $entrega->cliente || $data != $entrega->data_entrega) {
                $data = $entrega->data_entrega;
                $cliente = $entrega->cliente;
            ?>
                <div class="column is-12 grupo">
                    <span><?php echo $entrega->cliente; ?><br />
                        <small><?php echo data($data, 'completa-hora'); ?></span></small>
                </div>
            <?php
            } // if $cliente != $entrega->cliente
            ?>
            <div class="column is-12 linha" js-produto produto_id="<?php echo $entrega->produto_id; ?>" quantidade="<?php echo $entrega->quantidade; ?>" vendaproduto_id="<?php echo $entrega->vendaproduto_id; ?>">
                <div class="columns is-vcentered">
                    <div class="column" label="Produto"><?php echo $entrega->produto; ?></div>
                    <div class="column" label="Quantidade"><?php echo $entrega->quantidade; ?></div>
                    <div class="column" label="Preço">R$ <?php echo mask($entrega->preco, '$'); ?></div>
                    <div class="column is-1 has-text-centered acoes" label="Ações">
                        <div class="columns is-mobile is-vcentered">
                            <div class="column">
                                <a href="#confirmar-<?php echo $entrega->vendaproduto_id; ?>" data-fancybox title="Devolução">
                                    <i class="fas fa-backspace"></i>
                                </a>
                                <div id="confirmar-<?php echo $entrega->vendaproduto_id; ?>" style="display: none;">
                                    <h3 class="subtitle"><?php echo $entrega->cliente; ?> devolveu <?php echo $entrega->quantidade; ?> <?php echo $entrega->produto; ?>?</h3><br>
                                    <div class="buttons is-centered">
                                        <button class="button is-link is-secondary" data-fancybox-close>
                                            Cancelar
                                        </button>
                                        <button class="button is-danger" js-devolver="<?php echo $entrega->vendaproduto_id; ?>">
                                            <span class="icon">
                                                <i class="fas fa-backspace"></i>
                                            </span>
                                            <span>Devolvido</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if ($entregas[$indice + 1]->cliente != $entrega->cliente || $entregas[$indice + 1]->data_entrega != $data) { ?>
                <div class="column is-12 linha rodape">
                    <div class="columns is-vcentered is-mobile">
                        <div class="column"><strong>Entrega: R$ <?php echo mask($total_entrega, '$'); ?></strong></div>
                    </div>
                </div>
            <?php
                $total_entrega = 0;
            } // $entrega[$indice + 1]->cliente != $entrega[$indice + 1]->cliente 
            ?>
        <?php } // foreach $entregas 
        ?>
        <div class="column is-12 linha rodape">
            Total de entregas: R$ <?php echo mask($total, '$'); ?>
        </div>
    </div>
<?php } else { ?>
    <div class="sem-registro">
        Nada para exibir<br />
    </div>
<?php } // if !empty $entregas 
?>