<?php $metodopagamento = \controller\MetodoPagamento::_obter($args['id']); ?>

<section class="section pagina">
    <div class="container">
        <h1 class="subtitle">Cadastro de forma de recebimento</h1>

        <form id="formulario" action="#" method="post" data-id="<?php echo $metodopagamento->id; ?>">
            <div class="field">
                <label class="label">Nome</label>
                <div class="control">
                    <input id="nome" class="input" type="text" value="<?php echo $metodopagamento->nome; ?>" required>
                </div>
            </div>

            <div class="field is-grouped is-grouped-centered">
                <div class="control">
                    <a href="/painel/metodospagamentos" class="button is-link is-primary">Cancelar</a>
                </div>
                <div class="control">
                    <button id="salvar" class="button is-primary">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</section>