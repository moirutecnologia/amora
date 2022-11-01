<?php

// ROTAS DE NAVEGAÇÂO


// ROTAS PAINEL

$app->get('/painel/cadastro/usuario/{id}', function ($request, $response, $args) {
    $usuario = \controller\Usuario::_obter($args['id']);
    
    $pagina = 'painel/UsuarioFormulario';

    include '../bravo/Pagina.php';
});

// ROTAS SITE

// ROTAS DE AÇÃO

// ROTAS DE CRON
$app->get('/painel/extra/amora', function ($request, $response, $args) {
    $usuarios = \controller\Usuario::_listar(array());

    foreach($usuarios as $usuario){
        enviaremail($usuario->email, 'Amora', 'Conheça a Amora', 'Conheca', array());
    }

    echo 'foi!';

});