<section class="section pagina-lista">
    <div class="container is-fullhd">
        <div class="columns">
            <div class="column is-10">
                <h2 class="subtitle">A receber</h2>
            </div>
            <div class="column">
                <div class="buttons is-right">
                    <a href="/painel/cadastro/pagamento?voltar=saldo" class="button is-primary is-link">
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
        </div>

        <div js-tabela>
            <?php
            $parametros = $_GET;
            include '../view/painel/includes/pagamentos-saldo-tabela.php';
            ?>
        </div>
    </div>
</section>