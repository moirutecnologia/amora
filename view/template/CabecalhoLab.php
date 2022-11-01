<?php
global $_usuario;
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>amora</title>
    <meta name="robots" content="noindex, follow" />

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/bulma.min.css">
    <link rel="stylesheet" href="/css/custom-painelv2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.4/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.3/dist/css/bulma-carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css" integrity="sha512-nNlU0WK2QfKsuEmdcTwkeh+lhGs6uyOxuUs+n+0oXSYDok5qy0EI0lt01ZynHq6+p/tbgpZ7P+yUb+r71wqdXg==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://kit.fontawesome.com/3523aa0081.js" crossorigin="anonymous"></script>

    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#d25a65">
    <meta name="msapplication-TileColor" content="#d25a65">
    <meta name="theme-color" content="#d25a65">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ECGS7BH2CH"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-ECGS7BH2CH');
    </script>

</head>

<body>
    <article class="message is-success">
        <i class="icon"></i>
        <div class="message-body">
        </div>
    </article>

    <div class="logo">
        <!-- <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28"> -->
        <a href="/painel">amora</a>
    </div>

    <div>
        <nav href="#" data-fancybox-menu>
            <span></span>
            <span></span>
            <span></span>
        </nav>
        <div class="menu" style="display: none;">
            <div class="columns acesso-rapido">
                <div class="column has-text-centered">
                    <a href="/painel/cadastro/venda" class="button is-primary is-link is-large">
                        <span class="icon">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span>Vendas</span>
                    </a>
                </div>
                <div class="column has-text-centered">
                    <a href="/painel/cadastro/pagamento" class="button is-primary is-link is-large">
                        <span class="icon">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span>Recebimento</span>
                    </a>
                </div>
                <div class="column has-text-centered">
                    <a href="/painel/relatorios" class="button is-primary is-link is-large">
                        <span>Relatórios</span>
                    </a>
                </div>
            </div>
            <div class="columns is-multiline">
                <div class="column is-3">
                    <h2 class="subtitle">Recebimentos</h2>
                    <a href="/painel/pagamentos">Recebidos</a>
                    <a href="/painel/saldo">A receber</a>
                </div>
                <div class="column is-3">
                    <h2 class="subtitle">Entregas</h2>
                    <a href="/painel/aguardandoentrega">Aguardando entrega</a>
                    <a href="/painel/entregas">Entregas realizadas</a>
                </div>
                <div class="column is-3">
                    <h2 class="subtitle">Produtos</h2>
                    <a href="/painel/produtos">Todos produtos</a>
                    <a href="/painel/cadastro/produto">Cadastrar produtos</a>
                    <a href="/painel/marcas" nivel="1">Todos fornecedores</a>
                    <a href="/painel/cadastro/marca" nivel="1">Cadastrar fornecedor</a>
                </div>
                <div class="column is-3">
                    <h2 class="subtitle">Investimentos</h2>
                    <a href="/painel/investimentos">Todos investimentos</a>
                    <a href="/painel/cadastro/investimento">Cadastrar investimento</a>
                    <a href="/painel/investimentostipos" nivel="1">Todos tipos de investimento</a>
                    <a href="/painel/cadastro/investimentotipo" nivel="1">Cadastrar tipo de investimento</a>
                </div>
                <div class="column is-3">
                    <h2 class="subtitle">Clientes</h2>
                    <a href="/painel/clientes">Todos clientes</a>
                    <a href="/painel/cadastro/cliente">Cadastrar cliente</a>
                </div>
                <div class="column is-3">
                    <h2 class="subtitle">Formas de recebimento</h2>
                    <a href="/painel/metodospagamentos">Todas formas de recebimento</a>
                    <a href="/painel/cadastro/metodopagamento">Cadastrar forma de recebimento</a>
                </div>
                <div class="column is-3">
                    <h2 class="subtitle">
                        <?php
                        $nome = explode(' ', $_usuario->nome);
                        echo $nome[0];
                        ?>
                    </h2>
                    <a href="/painel/meus-dados">Meus dados</a>
                    <a href="/painel/trocar-senha">Trocar senha</a>
                    <?php if ($_usuario->assinante) { ?>
                        <a href="https://wa.me/5551996777932?text=Olá! Preciso de ajuda com a Amora" target="_blank">Suporte</a>
                    <?php } // if $_usuario->assinante 
                    ?>
                    <a href="/sair">Sair</a>
                </div>
            </div>
        </div>
    </div>