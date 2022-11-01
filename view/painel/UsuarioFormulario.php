<?php

$usuario->perfil_ids = json_decode($usuario->perfil_ids);

?>

<section class="section pagina">
    <div class="container">
        <h1 class="subtitle">Cadastro de usuario</h1>

        <form id="formulario" action="#" method="post" data-id="<?php echo $usuario->id; ?>">
            <div class="field">
                <label class="label">Nome</label>
                <div class="control">
                    <input id="nome" class="input" type="text" value="<?php echo $usuario->nome; ?>" required>
                </div>
            </div>

            <div class="field">
                <label class="label">E-mail</label>
                <div class="control">
                    <input id="email" class="input" type="email" value="<?php echo $usuario->email; ?>" required>
                </div>
            </div>

            <div class="field">
                <label class="label">Perfil</label>
                <div class="control">
                    <?php $perfis = \controller\Perfil::_listar(); ?>
                    <div class="select is-multiple is-fullwidth">
                        <select id="perfil_ids" required multiple size="<?php echo count($perfis); ?>">
                            <?php foreach ($perfis as $perfil) { ?>
                                <option <?php echo in_array($perfil->id, $usuario->perfil_ids) ? 'selected' : ''; ?> value="<?php echo $perfil->id; ?>"><?php echo $perfil->nome; ?></option>
                            <?php } // foreach $perfis 
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="field">
                <label class="label">Senha <small>Deixar em branco para manter a senha atual</small></label>
                <div class="control">
                    <input id="senha" class="input" type="text">
                </div>
            </div>

            <div class="field is-grouped is-grouped-centered">
                <div class="control">
                    <a href="/painel/usuarios" class="button is-link is-primary">Cancelar</a>
                </div>
                <div class="control">
                    <button id="salvar" class="button is-primary">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</section>