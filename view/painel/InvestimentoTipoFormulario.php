<?php $investimentotipo = \controller\InvestimentoTipo::_obter($args['id']); ?>

<section class="section pagina">
    <div class="container">
        <h1 class="subtitle">Cadastro de tipo de investimento</h1>

        <form id="formulario" action="#" method="post" data-id="<?php echo $investimentotipo->id; ?>">
            <div class="field">
                <label class="label">Nome</label>
                <div class="control">
                    <input id="nome" class="input" type="text" value="<?php echo $investimentotipo->nome; ?>" required>
                </div>
            </div>

            <div class="field is-grouped is-grouped-centered">
                <div class="control">
                    <a href="/painel/investimentostipos" class="button is-link is-primary">Cancelar</a>
                </div>
                <div class="control">
                    <button id="salvar" class="button is-primary">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</section>