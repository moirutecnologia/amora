<?php global $_usuario; ?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>amora</title>
    <meta property="description" content="Plataforma de gerenciamento de vendas, pagamentos e estoque. Simples e fácil de usar. Plano grátis e assinatura. Seu negócio, sua forma de trabalhar. A Amora visa facilitar o dia a dia de quem trabalha com vendas, representações ou produção própria." />

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Itim&display=swap" rel="stylesheet">
    <style>
        <?php
        include 'css/bulma.min.css';
        include 'css/custom-painel.css';
        include 'css/custom-site.css';
        ?>
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css" integrity="sha512-nNlU0WK2QfKsuEmdcTwkeh+lhGs6uyOxuUs+n+0oXSYDok5qy0EI0lt01ZynHq6+p/tbgpZ7P+yUb+r71wqdXg==" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/3523aa0081.js" crossorigin="anonymous"></script>

    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#d25a65">
    <meta name="msapplication-TileColor" content="#d25a65">
    <meta name="theme-color" content="#d25a65">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script src="https://www.googletagmanager.com/gtag/js?id=G-ECGS7BH2CH"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-ECGS7BH2CH');
    </script>

</head>

<body style="background-color: #fff;">

    <article class="message is-success">
        <i class="icon"></i>
        <div class="message-body">
        </div>
    </article>

    <div class="navbar-brand">
        <a class="navbar-item marca" href="/painel">
            <!-- <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28"> -->
            <div>
                <strong>amora</strong>
            </div>
        </a>
        <div class="navbar-item">
            <div class="buttons">
                <a href="/painel/login" class="navbar-item button is-primary is-link">
                    <span class="icon">
                        <i class="far fa-user"></i>
                    </span>
                    <span>Acessar</span>
                </a>
            </div>
        </div>
        <div class="navbar-item">
            <div class="buttons">
                <a href="/painel/cadastrar" class="navbar-item button is-primary is-link">
                    <span class="icon">
                        <i class="fas fa-plus-circle"></i>
                    </span>
                    <span>Cadastrar</span>
                </a>
            </div>
        </div>
        <!-- <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarmenu">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a> -->
    </div>

    <div id="navbarmenu" class="navbar-menu">
        <div class="navbar-start">

        </div>
        <div class="navbar-end">

        </div>
    </div>