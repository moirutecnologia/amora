<div class="container-login">
    <div class="columns formulario is-multiline">
        <div class="column is-12 has-text-centered">
            <a class="marca marca-login" href="/">
                <!-- <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28"> -->
                <div>
                    <strong>amora</strong>
                </div>
            </a>
        </div>
        <div class="column is-12">
            <div class="columns">
                <div class="column is-12">
                    <form id="formulario-login" action='#' method='post'>
                        <div class="field">
                            <label class="label">Nome</label>
                            <div class="control">
                                <input id="nome" class="input" type="text" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">E-mail</label>
                            <div class="control">
                                <input id="email" class="input" type="email" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">WhatsApp</label>
                            <div class="control">
                                <input id="whatsapp" class="input" type="tel" mascara="telefone" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Senha</label>
                            <div class="control">
                                <input id="senha" class="input" type="password" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="checkbox">
                                <input type="checkbox" name="termos" id="termos" required>
                                Concordo com <a href="/termos-de-servico" target="_blank">termos de serviço</a>
                            </label>
                        </div>

                        <div class="field">
                            <label class="checkbox">
                                <input type="checkbox" name="cookies" id="cookies" required>
                                Concordo com <a href="/politica-de-cookies" target="_blank">política de cookies</a>
                            </label>
                        </div>

                        <div class="field is-grouped is-grouped-centered">
                            <div class="control">
                                <button id="salvar" class="button is-primary">Cadastrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>