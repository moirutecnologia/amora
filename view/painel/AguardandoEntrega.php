<section class="section pagina-lista">
    <div class="container is-fullhd">
        <div class="columns">
            <div class="column">
                <h2 class="subtitle">Aguardando entrega</h2>
            </div>
        </div>

        <a href="#filtro" class="filtro-mobile" data-fancybox><i class="fas fa-search"></i></a>
        <div id="filtro" class="columns filtro">
            <div class="column is-2">
                <div class="field">
                    <label class="label">Fornecedor</label>
                    <div class="select is-fullwidth">
                        <select id="marca_id" js-filtro-change>
                            <?php include '../view/painel/includes/marcas-opcoes.php'; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="column is-2">
                <div class="field">
                    <label class="label">Cliente</label>
                    <div class="control">
                        <div class="select is-fullwidth com-filtro">
                            <input type="text" placeholder="Selecione">
                            <select id="cliente_id" js-filtro-change>
                                <?php include '../view/painel/includes/clientes-opcoes.php'; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div js-tabela>
            <?php
            $parametros = $_GET;
            include '../view/painel/includes/aguardandoentrega-tabela.php';
            ?>
        </div>
    </div>
</section>