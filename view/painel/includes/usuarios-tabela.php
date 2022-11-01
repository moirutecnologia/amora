<?php

$parametros['pagina'] = $_GET['pagina'] ?? 1;

$usuarios = \controller\Usuario::_listar($parametros);

?>
<?php if (!empty($usuarios->resultado)) { ?>
    <div class="columns is-multiline tabela">
        <div class="column is-12 linha cabecalho is-hidden-touch">
            <div class="columns">
                <div class="column">Nome</div>
                <div class="column">E-mail</div>
                <div class="column is-1 has-text-centered">Ações</div>
            </div>
        </div>

        <?php foreach ($usuarios->resultado as $usuario) { ?>
            <div class="column is-12 linha">
                <div class="columns is-vcentered">
                    <div class="column" label="Nome"><?php echo $usuario->nome; ?></div>
                    <div class="column" label="E-mail"><?php echo $usuario->email; ?></div>
                    <div class="column is-1 has-text-centered acoes" label="Ações">
                        <div class="columns is-mobile">
                            <div class="column">
                                <a href="/painel/cadastro/usuario/<?php echo $usuario->id; ?>" title="Editar">
                                    <i class="far fa-edit"></i>
                                </a>
                            </div>
                            <div class="column">
                                <a href="#confirmar-<?php echo $usuario->id; ?>" data-fancybox title="Excluir">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                                <div id="confirmar-<?php echo $usuario->id; ?>" style="display: none;">
                                    <h3 class="subtitle">Confirma a exclusão de <?php echo $usuario->nome; ?>?</h3><br>
                                    <div class="buttons is-centered">
                                        <button class="button is-link is-secondary" data-fancybox-close>
                                            Cancelar
                                        </button>
                                        <button class="button is-danger" js-excluir="<?php echo $usuario->id; ?>" controller="usuario">
                                            <span class="icon">
                                                <i class="far fa-trash-alt"></i>
                                            </span>
                                            <span>Excluir</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } // foreach $usuarios 
        ?>
    </div>
    <div class="paginacao">
        <?php paginas($parametros, $usuarios->total_paginas); ?>
    </div>
<?php } else { ?>
    <div class="sem-registro">
        Sem usuários para exibir<br />
    </div>
<?php } // if !empty $usuarios 
?>