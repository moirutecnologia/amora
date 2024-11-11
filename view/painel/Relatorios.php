<section class="section pagina-lista">
    <div class="container is-fullhd">
        <h2 class="subtitle">Relatórios</h2>

        <a href="#filtro" class="filtro-mobile" data-fancybox><i class="fas fa-search"></i></a>
        <div id="filtro" class="columns filtro is-multiline">
            <div class="column is-3">
                <div class="field">
                    <label class="label">Relatório</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select id="relatorio">
                                <option value="">Selecione</option>
                                <option value="cliente">Cliente</option>
                                <option value="investimento">Investimento</option>
                                <option value="marca">Fornecedor</option>
                                <option value="metodopagamento">Forma de recebimento</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column is-3">
                <div class="field">
                    <label class="label">Tipo</label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select id="tipo" js-filtro-change>
                                <option value="">Selecione o relatório</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column is-4" js-filtro="clientes" style="display: none;">
                <div class="field">
                    <label class="label">Produto</label>
                    <div class="control">
                        <div class="select is-fullwidth com-filtro">
                            <input type="text" placeholder="Selecione">
                            <select id="produto_id" js-filtro-change>
                                <?php include '../view/painel/includes/produtos-opcoes.php'; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column is-2" js-filtro="clientes" style="display: none;">
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
            <div class="column is-2" js-filtro="marcas" style="display: none;">
                <div class="field">
                    <label class="label">Fornecedor</label>
                    <div class="select is-fullwidth">
                        <select id="marca_id" js-filtro-change>
                            <?php include '../view/painel/includes/marcas-opcoes.php'; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="column is-2" js-filtro="metodos-pagamentos" style="display: none;">
                <div class="field">
                    <label class="label">Forma de recebimento</label>
                    <div class="select is-fullwidth com-filtro">
                        <input type="text" placeholder="Selecione">
                        <select id="metodopagamento_id" js-filtro-change>
                            <?php include '../view/painel/includes/metodospagamentos-opcoes.php'; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="column is-2" js-filtro="investimentos-tipos" style="display: none;">
                <div class="field">
                    <label class="label">Tipo de investimento</label>
                    <div class="select is-fullwidth">
                        <select id="investimentotipo_id" js-filtro-change>
                            <?php include '../view/painel/includes/investimentostipos-opcoes.php'; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="column is-2" js-filtro="data-de" style="display: none;">
                <div class="field">
                    <label class="label">De</label>
                    <div class="control">
                        <input id="data_de" class="input" type="date" js-filtro-change <?php echo !$_usuario->assinante ? 'js-seja-assinante' : ''; ?> value="<?php echo !$_usuario->assinante ? date('Y-m-d', strtotime('-2 months')) : date('Y') . '-01-01'; ?>">
                    </div>
                </div>
            </div>
            <div class="column is-2" js-filtro="data-ate" style="display: none;">
                <div class="field">
                    <label class="label">Até</label>
                    <div class="control">
                        <input id="data_ate" class="input" type="date" js-filtro-change <?php echo !$_usuario->assinante ? 'js-seja-assinante' : ''; ?> value="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>
            </div>
        </div>

        <div js-tabela>
            <div class="sem-registro">
                Selecione o relatório
            </div>
        </div>
    </div>
</section>