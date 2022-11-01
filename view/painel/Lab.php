<section class="section">
    <div class="container is-fullhd">

        <div class="columns">
            <div class="column is-10">
                <h2 class="subtitle">Clientes</h2>
            </div>
            <div class="column">
                <div class="buttons is-right">
                    <a href="/painel/cadastro/cliente" class="button is-primary is-link">
                        <span class="icon">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span>Cadastrar cliente</span>
                    </a>
                </div>
            </div>
        </div>

        <a href="#filtro" class="filtro-mobile" data-fancybox><i class="fas fa-search"></i></a>
        <div id="filtro" class="columns filtro">
            <div class="column is-2">
                <div class="field">
                    <label class="label">Busca</label>
                    <div class="control">
                        <input id="busca" class="input" type="text" js-filtro-change value="<?php echo $_GET['busca']; ?>">
                    </div>
                </div>
            </div>
        </div>

        <div js-tabela>
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
        </div>
    </div>
</section>

<section class="section pagina">
    <div class="container formulario">
        <h2 class="subtitle">Cadastro de usuário</h2>

        <form id="formulario" action="#" method="post" data-id="<?php echo $usuario->id; ?>">
            <div class="columns is-multiline">
                <div class="column is-4">
                    <div class="field">
                        <label class="label">Nome</label>
                        <div class="control">
                            <input id="nome" class="input" type="text" value="<?php echo $usuario->nome; ?>" required>
                        </div>
                    </div>
                </div>
                <div class="column is-4">
                    <div class="field">
                        <label class="label">E-mail</label>
                        <div class="control">
                            <input id="email" class="input" type="email" value="<?php echo $usuario->email; ?>" required>
                        </div>
                    </div>
                </div>
                <div class="column is-4">
                    <div class="field">
                        <label class="label">Senha <small>Deixar em branco para manter</small></label>
                        <div class="control">
                            <input id="senha" class="input" type="text">
                        </div>
                    </div>
                </div>
                <div class="column is-4">
                    <div class="field">
                        <label class="label">
                            <div class="columns is-mobile is-gapless mb-0">
                                <div class="column is-4">
                                    Fornecedor
                                </div>
                                <div class="column has-text-right">
                                    <a href="#novo" data-fancybox class="button is-small is-primary is-link">
                                        <span class="icon">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <span>fornecedor</span>
                                    </a>
                                </div>
                            </div>
                        </label>
                        <div class="select is-fullwidth com-filtro">
                            <input type="text" placeholder="Selecione">
                            <select id="marca_id" required>
                                <?php include '../view/painel/includes/marcas-opcoes.php'; ?>
                            </select>
                        </div>
                        <div id="novo" class="columns" style="display: none;">
                            <div class="column">
                                <h2 class="subtitle">Novo fornecedor</h2>
                                <div class="field">
                                    <label class="label">Nome</label>
                                    <div class="control">
                                        <input id="nome" class="input" type="text" required>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="label">Comissão</label>
                                    <div class="control">
                                        <input id="comissao" class="input" mascara="valor" type="tel" required>
                                    </div>
                                </div>

                                <div class="field is-grouped is-grouped-centered">
                                    <div class="control">
                                        <button data-fancybox-close class="button is-link is-primary">Cancelar</button>
                                    </div>
                                    <div class="control">
                                        <button id="salvar-novo" class="button is-primary">Salvar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-12">
                    <div class="field">
                        <label class="label">Perfil</label>
                        <div class="control">
                            <?php $perfis = \controller\Perfil::_listar(); ?>
                            <div class="select is-multiple is-fullwidth">
                                <select id="perfil_ids" required multiple size="<?php echo count($perfis); ?>">
                                    <?php foreach ($perfis as $perfil) { ?>
                                        <option <?php echo in_array($perfil->id, $usuario->perfil_ids) ? 'selected' : ''; ?> value="<?php echo $perfil->id; ?>"><?php echo $perfil->nome; ?></option>
                                    <?php } // foreach $perfis 
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-12">
                    <div class="field">
                        <label class="label">Arquivo</label>
                        <bulma-upload repositorio="lab" class="columns is-multiline is-gapless is-mobile">
                            <arquivo class="column is-11 arquivo">
                                <input class="file-input" type="file">
                            </arquivo>
                            <div class="column has-text-centered is-1 acoes">
                                <a href="#" data-fancybox-sibling>
                                    <i class="fas fa-ellipsis-v"></i>
                                </a>
                                <div>
                                    <div class="field is-grouped is-grouped-centered botoes">
                                        <div class="control">
                                            <button class="button is-primary" js-visualizar>Visualizar</button>
                                        </div>
                                        <div class="control">
                                            <a download class="button is-primary" js-baixar>Baixar</a>
                                        </div>
                                        <div class="control">
                                            <button class="button is-primary" js-remover>Remover</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </bulma-upload>
                    </div>
                </div>
                <div class="column is-12">
                    <div class="field" bulma-galeria repositorio="lab" galeria="novo">
                        <label class="label">Imagens</label>
                        <div class="columns is-multiline" imagens>
                        </div>
                        <div class="columns">
                            <div class="column is-12">
                                <div class="file is-centered is-boxed">
                                    <label class="file-label">
                                        <input class="file-input" type="file" multiple>
                                        <span class="file-cta">
                                            <span class="file-icon">
                                                <i class="fas fa-upload"></i>
                                            </span>
                                            <span class="file-label">
                                                Clique para selecionar ou arraste aqui
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-12">
                    <div class="field">
                        <label class="label">Editor</label>
                        <bulma-editor>
                            <ferramentas>
                                <button negrito>Negrito</button>
                                <button italico>Itálico</button>
                                <button link>Link</button>
                                <button ul>Lista</button>
                                <button indent>Indent</button>
                                <button outdent>Outdent</button>
                                <button tabela>Tabela</button>
                                <button adicionarcoluna>+Coluna</button>
                                <button adicionarlinha>+Linha</button>
                                <button alinharesquerda>Alinhar esquerda</button>
                                <button alinharcentro>Alinhar centro</button>
                                <button alinhardireita>Alinhar direita</button>
                                <button flutuanteesquerda>Flutuante esquerda</button>
                            </ferramentas>
                            <conteudo contentEditable></conteudo>
                        </bulma-editor>
                    </div>
                </div>
            </div>
            <div class="field is-grouped is-grouped-centered botoes">
                <div class="control">
                    <a href="/painel/usuarios" class="button is-link is-primary">Cancelar</a>
                </div>
                <div class="control">
                    <button id="salvar" class="button is-primary">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</section>