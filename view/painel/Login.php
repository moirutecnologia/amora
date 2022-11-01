<?php

global $_usuario;

if (!empty($_usuario)) {
    header('location: /painel');
    exit;
}

?>

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
                            <label class="label">E-mail</label>
                            <div class="control">
                                <input id="email" class="input" type="email" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">
                                Senha <a href="#" id="esqueceu-senha"><small>Esqueceu a senha?</small></a>
                            </label>
                            <div class="control">
                                <input id="senha" class="input" type="password" required>
                            </div>
                        </div>

                        <div class="field is-grouped is-grouped-centered">
                            <div class="control">
                                <button id="entrar" class="button is-primary">Entrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>