<section class="section pagina-lista">
    <div class="container is-fullhd">
        <div class="columns">
            <div class="column is-10">
                <h2 class="subtitle">Investimentos</h2>
            </div>
            <div class="column">
                <div class="buttons is-right">
                    <a href="/painel/cadastro/investimento" class="button is-primary is-link">
                        <span class="icon">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span>Cadastrar investimento</span>
                    </a>
                </div>
            </div>
        </div>

        <a href="#filtro" class="filtro-mobile" data-fancybox><i class="fas fa-search"></i></a>
        <div id="filtro" class="columns filtro">
            <div class="column is-2">
                <div class="field">
                    <label class="label">Tipo</label>
                    <div class="control">
                        <?php $investimentostipos = \controller\InvestimentoTipo::_listar(); ?>
                        <div class="select is-fullwidth">
                            <select id="investimentotipo_id" js-filtro-change>
                                <option value="">Todos</option>
                                <?php foreach ($investimentostipos as $$investimentotipo) { ?>
                                    <option value="<?php echo $$investimentotipo->id; ?>"><?php echo $$investimentotipo->nome; ?></option>
                                <?php } // foreach $investimentostipos 
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div js-tabela>
            <?php
            $parametros = $_GET;
            include '../view/painel/includes/investimentos-tabela.php';
            ?>
        </div>
    </div>
</section>