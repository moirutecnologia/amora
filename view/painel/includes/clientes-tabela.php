<?php

$parametros['pagina'] = $parametros['pagina'] ?? 1;

$clientes = \controller\Cliente::_listar($parametros);

?>
<?php if (!empty($clientes->resultado)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Nome</div>
                <div class="column">E-mail</div>
                <div class="column">WhatsApp</div>
                <div class="column is-1 has-text-centered">Ações</div>
            </div>
        </div>

        <?php foreach ($clientes->resultado as $cliente) { ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered">
                    <div class="column" label="Nome"><?php echo $cliente->nome; ?></div>
                    <div class="column" label="E-mail">
                        <?php if (!empty($cliente->email)) { ?>
                            <a href="mailto:<?php echo $cliente->email; ?>" target="_blank" class="button is-rounded">
                                <span class="icon is-small">
                                    <i class="far fa-envelope"></i>
                                </span>
                                <span><?php echo $cliente->email; ?></span>
                            </a>
                        <?php } else { ?>
                            -
                        <?php } // if !empty $cliente->email 
                        ?>
                    </div>
                    <div class="column" label="WhatsApp">
                        <?php if (!empty($cliente->whatsapp)) { ?>
                            <a href="https://wa.me/55<?php echo $cliente->whatsapp; ?>" target="_blank" class="button is-rounded">
                                <span class="icon is-small">
                                    <i class="fab fa-whatsapp"></i>
                                </span>
                                <span><?php echo mask($cliente->whatsapp, '(##) #####-####'); ?></span>
                            </a>
                        <?php } else { ?>
                            -
                        <?php } // if !empty $cliente->whatsapp 
                        ?>
                    </div>
                    <div class="column is-1 has-text-centered acoes" label="Ações">
                        <div class="columns is-mobile">
                            <div class="column">
                                <a href="#confirmar-<?php echo $cliente->id; ?>" data-fancybox title="Excluir">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                                <div id="confirmar-<?php echo $cliente->id; ?>" style="display: none;">
                                    <h3 class="subtitle">Confirma a exclusão de <?php echo $cliente->nome; ?>?</h3><br>
                                    <div class="buttons is-centered">
                                        <button class="button is-link is-secondary" data-fancybox-close>
                                            Cancelar
                                        </button>
                                        <button class="button is-danger" js-excluir="<?php echo $cliente->id; ?>" controller="cliente">
                                            <span class="icon">
                                                <i class="far fa-trash-alt"></i>
                                            </span>
                                            <span>Excluir</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <a href="/painel/cadastro/cliente/<?php echo $cliente->id; ?>" title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } // foreach $clientes 
        ?>
    </div>
    <div class="paginacao">
        <?php paginas($parametros, $clientes->total_paginas); ?>
    </div>
<?php } else { ?>
    <div class="sem-registro">
        Sem clientes para exibir<br />
    </div>
<?php } // if !empty $clientes 
?>