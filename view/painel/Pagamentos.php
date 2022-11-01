<section class="section pagina-lista">
    <div class="container is-fullhd">
        <div class="columns">
            <div class="column is-10">
                <h2 class="subtitle">Recebimentos</h2>
            </div>
            <div class="column">
                <div class="buttons is-right">
                    <a href="/painel/cadastro/pagamento" class="button is-primary is-link">
                        <span class="icon">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span>Cadastrar recebimento</span>
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
            <div class="column is-2">
                <div class="field">
                    <div class="field">
                        <label class="label">Forma de recebimento</label>
                        <div class="control">
                            <div class="select is-fullwidth com-filtro">
                                <input type="text">
                                <select id="metodopagamento_id" js-filtro-change>
                                    <?php include '../view/painel/includes/metodospagamentos-opcoes.php'; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column is-2">
                <div class="field">
                    <label class="label">De</label>
                    <div class="control">
                        <input id="data_de" class="input" type="date" js-filtro-change value="<?php echo $_GET['data_de']; ?>">
                    </div>
                </div>
            </div>
            <div class="column is-2">
                <div class="field">
                    <label class="label">Até</label>
                    <div class="control">
                        <input id="data_ate" class="input" type="date" js-filtro-change value="<?php echo $_GET['data_ate']; ?>">
                    </div>
                </div>
            </div>
        </div>

        <div js-tabela>
            <?php
            $parametros = $_GET;
            include '../view/painel/includes/pagamentos-tabela.php';
            ?>
        </div>
    </div>
</section>