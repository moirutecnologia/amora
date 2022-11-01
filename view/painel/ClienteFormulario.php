<?php $cliente = \controller\Cliente::_obter($args['id']); ?>

<section class="section pagina">
    <div class="container">
        <h1 class="subtitle">Cadastro de cliente</h1>

        <form id="formulario" action="#" method="post" data-id="<?php echo $cliente->id; ?>">
            <div class="field">
                <label class="label">Nome</label>
                <div class="control">
                    <input id="nome" class="input" type="text" value="<?php echo $cliente->nome; ?>" required>
                </div>
            </div>

            <div class="field">
                <label class="label">E-mail</label>
                <div class="control">
                    <input id="email" class="input" type="mail" value="<?php echo $cliente->email; ?>">
                </div>
            </div>

            <div class="field">
                <label class="label">WhatsApp</label>
                <div class="control">
                    <input id="whatsapp" class="input" mascara="telefone" type="tel" value="<?php echo $cliente->whatsapp; ?>">
                </div>
            </div>

            <div class="field">
                <label class="label">Endereço</label>
                <div class="control">
                    <input id="endereco" class="input" type="text" value="<?php echo $cliente->endereco; ?>">
                </div>
            </div>

            <div class="field is-grouped is-grouped-centered">
                <div class="control">
                    <a href="/painel/clientes" class="button is-link is-primary">Cancelar</a>
                </div>
                <div class="control">
                    <button id="salvar" class="button is-primary">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</section>