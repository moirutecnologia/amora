<section class="section pagina">
    <div class="container">
        <h1 class="subtitle">Meus dados</h1>

        <form id="formulario" action='#' method='post'>
            <div class="field">
                <label class="label">Nome</label>
                <div class="control">
                    <input id="nome" class="input" type="text" value="<?php echo $_usuario->nome; ?>" required>
                </div>
            </div>

            <div class="field">
                <label class="label">E-mail</label>
                <div class="control">
                    <input id="email" class="input" type="email" value="<?php echo $_usuario->email; ?>" required>
                </div>
            </div>

            <div class="field">
                <label class="label">WhatsApp</label>
                <div class="control">
                    <input id="whatsapp" class="input" type="tel" mascara="telefone" value="<?php echo $_usuario->whatsapp; ?>" required>
                </div>
            </div>

            <div class="field is-grouped is-grouped-centered">
                <div class="control">
                    <button id="salvar" class="button is-primary">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</section>