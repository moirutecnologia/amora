<?php
if(empty($_usuario)){
    header('location: /');
    exit;
}
?>
<section class="section pagina">
    <div class="container">
        <h1 class="subtitle">Trocar senha</h1>

        <form id="formulario" action='#' method='post'>
            <div class="field">
                <label class="label">Senha atual</label>
                <div class="control">
                    <input id="senha" class="input" type="password" required>
                </div>
            </div>

            <div class="field">
                <label class="label">Nova senha</label>
                <div class="control">
                    <input id="nova_senha" class="input" type="password" required>
                </div>
            </div>

            <div class="field">
                <label class="label">Confirmar nova senha</label>
                <div class="control">
                    <input id="confirmar_senha" class="input" type="password" required>
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