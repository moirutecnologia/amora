<?php

$_versao = '2.2.5';

$_seo = array(
    'title' => 'Amora',
    'description' => '',
    //'image' => '/image/imagem-ditlanta.png',
);

$_pagina_padrao = 'Inicio';
$_cabecalho_padrao = 'CabecalhoLab';
$_rodape_padrao = 'RodapeLab';
$_rota_acesso = '/painel/login';
$_mostrar_erros = true;

$_paginas = array();

//Páginas de impressao
$_paginas[] = array('pagina' => 'painel/impressao-agenda', 'cabecalho' => 'CabecalhoImpressao', 'rodape' => 'RodapeImpressao');
$_paginas[] = array('pagina' => 'painel/impressao-orcamento', 'cabecalho' => 'CabecalhoImpressao', 'rodape' => 'RodapeImpressao');
$_paginas[] = array('pagina' => 'painel/impressao-ordens-de-servico', 'cabecalho' => 'CabecalhoImpressao', 'rodape' => 'RodapeImpressao');
$_paginas[] = array('pagina' => 'painel/impressao-cobrancas', 'cabecalho' => 'CabecalhoImpressao', 'rodape' => 'RodapeImpressao');

//Página de acesso
$_paginas[] = array('pagina' => 'painel/login', 'cabecalho' => 'CabecalhoLogin', 'rodape' => 'RodapeLogin');
$_paginas[] = array('pagina' => 'painel/cadastrar', 'cabecalho' => 'CabecalhoLogin', 'rodape' => 'RodapeLogin');

//Páginas painel
$_paginas[] = array('pagina' => 'painel/index', 'restrita' => true);
$_paginas[] = array('pagina' => 'painel/vendaformulario', 'restrita' => true);
$_paginas[] = array('pagina' => 'painel/pagamentos', 'restrita' => true);
$_paginas[] = array('pagina' => 'painel/saldo', 'restrita' => true);
$_paginas[] = array('pagina' => 'painel/aguardandoentrega', 'restrita' => true);
$_paginas[] = array('pagina' => 'painel/entregas', 'restrita' => true);
$_paginas[] = array('pagina' => 'painel/produtos', 'restrita' => true);
$_paginas[] = array('pagina' => 'painel/investimentos', 'restrita' => true);
$_paginas[] = array('pagina' => 'painel/clientes', 'restrita' => true);
$_paginas[] = array('pagina' => 'painel/clienteformulario', 'restrita' => true);
$_paginas[] = array('pagina' => 'painel/investimentostipos', 'restrita' => true);
$_paginas[] = array('pagina' => 'painel/investimentotipoformulario', 'restrita' => true);
$_paginas[] = array('pagina' => 'painel/marcas', 'restrita' => true);
$_paginas[] = array('pagina' => 'painel/marcaformulario', 'restrita' => true);
$_paginas[] = array('pagina' => 'painel/metodospagamentos', 'restrita' => true);
$_paginas[] = array('pagina' => 'painel/metodopagamentoformulario', 'restrita' => true);
$_paginas[] = array('pagina' => 'painel/relatorios', 'restrita' => true);
$_paginas[] = array('pagina' => 'painel/meus-dados', 'restrita' => true);

$_paginas[] = array('pagina' => 'painel/lab', 'cabecalho' => 'CabecalhoLab', 'rodape' => 'RodapeLab', 'restrita' => true);

//Páginas site
$_paginas[] = array('pagina' => 'inicio', 'cabecalho' => 'CabecalhoSite', 'rodape' => 'RodapeSite');
$_paginas[] = array('pagina' => 'termos-de-servico', 'cabecalho' => 'CabecalhoSite', 'rodape' => 'RodapeSite');
$_paginas[] = array('pagina' => 'politica-de-cookies', 'cabecalho' => 'CabecalhoSite', 'rodape' => 'RodapeSite');

$_metodos = array();

$_imagens = array();

$_imagens[] = array('repositorio' => 'produto', 'tamanho' => 'grande', 'largura' => 1000);

$_banco_servidor;
$_banco_nome;
$_banco_usuario;
$_banco_senha;

if (in_array($_SERVER['SERVER_NAME'], array('amora.moiru.com.br'))) {

    $_mostrar_erros = true;

    $_banco_servidor = 'localhost';
    $_banco_nome = 'amora';
    $_banco_usuario = 'amora';
    $_banco_senha = 'dBPh%#P8Jo52';

    $_email_de = 'naoresponda@mg.amora.cusco.dev';
    $_email_de_nome = 'amora';

} else if ($_SERVER['SERVER_NAME'] == 'www.amora.cusco.dev') {
    header('location: https://amora.cusco.dev' . $_SERVER['REQUEST_URI']);
    exit;
}