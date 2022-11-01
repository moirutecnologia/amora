<?php $marca = \controller\Marca::_obter($args['id']); ?>

<section class="section pagina">
    <div class="container">
        <h1 class="subtitle">Cadastro de fornecedor</h1>

        <form id="formulario" action="#" method="post" data-id="<?php echo $marca->id; ?>">
            <div class="field">
                <label class="label">Nome</label>
                <div class="control">
                    <input id="nome" class="input" type="text" value="<?php echo $marca->nome; ?>" required>
                </div>
            </div>

            <div class="field">
                <label class="label">Comissão</label>
                <div class="control">
                    <input id="comissao" class="input" mascara="valor" type="tel" value="<?php echo $marca->comissao; ?>" required>
                </div>
            </div>

            <div class="field is-grouped is-grouped-centered">
                <div class="control">
                    <a href="/painel/marcas" class="button is-link is-primary">Cancelar</a>
                </div>
                <div class="control">
                    <button id="salvar" class="button is-primary">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</section>