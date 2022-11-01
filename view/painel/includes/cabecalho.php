<?php
global $_usuario;
?>

<div class="navbar-brand">
    <a class="navbar-item marca" href="/painel">
        <!-- <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28"> -->
        <div>
            <strong>amora</strong>
        </div>
    </a>
    <div class="navbar-item <?php echo in_array($pagina, array('painel/vendaformulario')) ? 'is-active' : ''; ?>">
        <div class="buttons">
            <a href="/painel/cadastro/venda" class="navbar-item button is-primary is-link">
                <span class="icon">
                    <i class="fas fa-plus"></i>
                </span>
                <span>Vendas</span>
            </a>
        </div>
    </div>
    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarmenu">
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
        <span aria-hidden="true"></span>
    </a>
</div>

<div id="navbarmenu" class="navbar-menu">
    <div class="navbar-start">
        <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link <?php echo in_array($pagina, array('painel/pagamentos', 'painel/saldo')) ? 'is-active' : ''; ?>">
                Recebimentos
            </a>
            <div class="navbar-dropdown">
                <a href="/painel/pagamentos" class="navbar-item <?php echo in_array($pagina, array('painel/pagamento')) ? 'is-active' : ''; ?>">
                    Recebidos
                </a>
                <a href="/painel/saldo" class="navbar-item <?php echo in_array($pagina, array('painel/saldo')) ? 'is-active' : ''; ?>">
                    A receber
                </a>
            </div>
        </div>
        <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link <?php echo in_array($pagina, array('painel/aguardandoentrega', 'painel/entregas')) ? 'is-active' : ''; ?>" href="#">
                Entregas
            </a>
            <div class="navbar-dropdown">
                <a href="/painel/aguardandoentrega" class="navbar-item <?php echo in_array($pagina, array('painel/aguardandoentrega')) ? 'is-active' : ''; ?>">
                    Aguardando entrega
                </a>
                <a href="/painel/entregas" class="navbar-item <?php echo in_array($pagina, array('painel/entregas')) ? 'is-active' : ''; ?>">
                    Entregas realizadas
                </a>
            </div>
        </div>
        <div class="navbar-item has-dropdown is-hoverable">
            <a class="navbar-link">
                Cadastros
            </a>
            <div class="navbar-dropdown">
                <a href="/painel/produtos" class="navbar-item <?php echo in_array($pagina, array('painel/produtos', 'painel/produtoformulario')) ? 'is-active' : ''; ?>">
                    Produtos
                </a>
                <a href="/painel/marcas" class="navbar-item <?php echo in_array($pagina, array('painel/marcas', 'painel/marcaformulario')) ? 'is-active' : ''; ?>">
                    Fornecedores
                </a>
                <a href="/painel/investimentos" class="navbar-item <?php echo in_array($pagina, array('painel/investimentos', 'painel/investimentoformulario')) ? 'is-active' : ''; ?>">
                    Investimento
                </a>
                <a href="/painel/investimentostipos" class="navbar-item <?php echo in_array($pagina, array('painel/investimentostipos', 'painel/marcaformulario')) ? 'is-active' : ''; ?>">
                    Tipo de investimento
                </a>
                <a href="/painel/clientes" class="navbar-item <?php echo in_array($pagina, array('painel/clientes', 'painel/clienteformulario')); ?>">
                    Clientes
                </a>
                <a href="/painel/metodospagamentos" class="navbar-item <?php echo in_array($pagina, array('painel/metodospagamentos', 'painel/investimentotipoformulario')) ? 'is-active' : ''; ?>">
                    Forma de recebimento
                </a>
            </div>
        </div>
        <a href="/painel/relatorios" class="navbar-item <?php echo $pagina == 'painel/relatorios' ? 'is-active' : ''; ?>">
            Relatorios
        </a>
    </div>
    <div class="navbar-end">
        <?php if (!empty($_usuario)) { ?>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link menu-usuario" js-logado-dash>
                    <?php
                    $nome = explode(' ', $_usuario->nome);
                    echo $nome[0];
                    ?>
                </a>
                <div class="navbar-dropdown menu-usuario">
                    <a href="/painel/meus-dados" class="navbar-item">
                        Meus dados
                    </a>
                    <a href="/painel/trocar-senha" class="navbar-item">
                        Trocar senha
                    </a>
                    <?php if ($_usuario->assinante) { ?>
                        <hr class="navbar-divider">
                        <a href="https://wa.me/5551996777932?text=Olá! Como funciona a Amora WhatsApp?" target="_blank" class="navbar-item">
                            Amora WhatsApp
                        </a>
                        <a href="https://wa.me/5551996777932?text=Olá! Preciso de ajuda com a Amora" target="_blank" class="navbar-item">
                            Suporte
                        </a>
                        <hr class="navbar-divider">
                    <?php } // if $_usuario->assinante 
                    ?>
                    <a href="/sair" class="navbar-item">
                        Sair
                    </a>
                </div>
            </div>
        <?php } // if !empty $_usuario 
        ?>
    </div>
</div>