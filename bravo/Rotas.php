<?php

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

global $_mostrar_erros;

$app = new Slim\App([

    'settings' => [
        'displayErrorDetails' => $_mostrar_erros,
        'debug' => true
    ]

]);

// Middleware para rotas CASE INSENSITIVE
$app->add(function ($request, $response, $next) {
    $uri = $request->getUri();
    // $uri = $uri->withPath($uri->getPath());
    $request = $request->withUri($uri);

    if (isset($_COOKIE['token'])) {
        global $_usuario;

        $_token = $_COOKIE['token'];
        $controller = new \controller\Usuario();
        $_usuario = $controller->obterPorToken($_token);
        $_usuario->permissoes = array_unique(json_decode($_usuario->permissoes));

        $permissoes = array();

        foreach ($_usuario->permissoes as $permissao) {
            $permissoes[$permissao] = 1;
        }

        $_usuario->permissoes = (object)$permissoes;
    }

    if (isset($_COOKIE['token_cliente'])) {
        global $_cliente;

        $_token = $_COOKIE['token_cliente'];
        $controller = new \controller\Cliente();
        $_cliente = $controller->obterPorToken($_token);
    }

    $response = $next($request, $response);

    return $response;
});

// Middleware para rotas terminando com barra
$app->add(function (Request $request, Response $response, callable $next) {
    $uri = $request->getUri();
    $path = $uri->getPath();
    if ($path != '/' && substr($path, -1) == '/') {
        // permanently redirect paths with a trailing slash
        // to their non-trailing counterpart
        $uri = $uri->withPath(substr($path, 0, -1));

        if ($request->getMethod() == 'GET') {
            return $response->withRedirect((string)$uri, 301);
        } else {
            return $next($request->withUri($uri), $response);
        }
    }

    return $next($request, $response);
});

include "RotasPersonalizadas.php";

// ROTAS DE NAVEGAÇÃO
$diretorios = new DirectoryIterator("../view");
foreach ($diretorios as $diretorio) {

    if ($diretorio->isDir() && !$diretorio->isDot() && !in_array($diretorio->getFilename(), array('template', 'email'))) {

        $app->get('/' . $diretorio->getFilename(), function ($request, $response, $args) {

            global $_usuario;
            global $_cliente;

            $pagina = explode('/', $request->getUri()->getPath())[1] . '/index';

            valida_acesso_pagina_restrita($pagina);

            include '../bravo/Pagina.php';

        });


        $app->get('/' . $diretorio->getFilename() . '/{pagina}', function ($request, $response, $args) {

            global $_usuario;
            global $_cliente;

            $pagina = explode('/', $request->getUri()->getPath())[1] . '/' . $args['pagina'];

            valida_acesso_pagina_restrita($pagina);

            include '../bravo/Pagina.php';

        });

        $app->get('/' . $diretorio->getFilename() . '/cadastro/{pagina}', function ($request, $response, $args) {

            global $_usuario;
            global $_cliente;

            $pagina = explode('/', $request->getUri()->getPath())[1] . '/' . $args['pagina'] . 'formulario';

            valida_acesso_pagina_restrita($pagina, $request->getUri()->getPath());

            include '../bravo/Pagina.php';

        });

        $app->get('/' . $diretorio->getFilename() . '/cadastro/{pagina}/{id}', function ($request, $response, $args) {

            global $_usuario;
            global $_cliente;

            $pagina = explode('/', $request->getUri()->getPath())[1] . '/' . $args['pagina'] . 'formulario';

            valida_acesso_pagina_restrita($pagina, $request->getUri()->getPath());

            include '../bravo/Pagina.php';

        });

    }
}

$app->get("/imagem/{repositorio}/{tamanho}[/{imagem:.*}]", function ($request, $response, $args) {

    global $_imagens;

    $tamanho = array();

    foreach ($_imagens as $imagem) {
        if ($imagem['repositorio'] == $args['repositorio'] && $imagem['tamanho'] == $args['tamanho']) {
            $tamanho = $imagem;
            break;
        }
    }

    $file = arquivo_nome_real('arquivo/' . $tamanho['repositorio'] . '/' . $args['imagem']);

    list($width, $height) = getimagesize($file);

    $tamanho['largura'] = $tamanho['largura'] ?? -1;
    $tamanho['altura'] = $tamanho['altura'] ?? -1;

    if ($tamanho['largura'] > $width) {
        $tamanho['largura'] = $width;
    }

    if ($tamanho['altura'] > $height) {
        $tamanho['altura'] = $height;
    }

    ob_start();

    resizeImage($file, $tamanho['largura'], null);

    $imagedata = ob_get_contents();

    ob_clean();
    ob_end_clean();

    $response->write($imagedata);
    return $response->withHeader('Content-Type', 'image/jpeg');

});

$app->get('/[{pagina}]', function ($request, $response, $args) {

    global $_pagina_padrao;
    global $_seo;
    global $_token;
    global $_paginas;
    global $_usuario;
    global $_cliente;
    global $_rota_acesso;

    global $_usuario_id;
    global $_empresa_id;

    $indice = array_search(strtolower($args['pagina']), array_column($_paginas, 'pagina'));

    if ($indice !== false) {
        if (!empty($_paginas[$indice]['seo'])) {
            $_seo = $_paginas[$indice]['seo'];
        }
    }

    if ($args['pagina'] != 'sair' && $args['pagina'] != 'saircliente') {
        $pagina = $args['pagina'] ?? 'Inicio';

        valida_acesso_pagina_restrita($pagina);

        include '../bravo/Pagina.php';
    } else if ($args['pagina'] == 'sair') {
        $controller = new \controller\Usuario();
        $controller->sair(array('token' => $_COOKIE['token']));

        setcookie("token", '', time() - 1000, '/');

        header('location: ' . $_rota_acesso);
        exit;
    } else if ($args['pagina'] == 'saircliente') {
        $controller = new \controller\Cliente();
        $controller->sair();

        setcookie("token_cliente", '', time() - 1000, '/');
        setcookie("cliente", '', time() - 1000, '/');

        header('location: /');
        exit;
    }

});

$app->get('/cadastro/{pagina}', function ($request, $response, $args) {

    global $_usuario;
    global $_cliente;

    $pagina = "{$args["pagina"]}formulario";

    valida_acesso_pagina_restrita($pagina, $request->getUri()->getPath());

    include '../bravo/Pagina.php';

});

$app->get('/cadastro/{pagina}/{id}', function ($request, $response, $args) {

    global $_usuario;
    global $_cliente;

    $pagina = "{$args["pagina"]}formulario";

    valida_acesso_pagina_restrita($pagina, $request->getUri()->getPath());

    include "../bravo/Pagina.php";

});

$app->get("/imprimir/{pagina}", function ($request, $response, $args) {

    global $_usuario;
    global $_cliente;

    $pagina = "{$args["pagina"]}imprimir";

    include "../bravo/Imprimir.php";

});

$app->get("/imprimir/{pagina}/{id}", function ($request, $response, $args) {

    global $_usuario;
    global $_cliente;

    $pagina = "{$args["pagina"]}imprimir";

    include "../bravo/Imprimir.php";

});

// ROTAS DE AÇÕES
$app->post('/imagem/upload', function ($request, $response, $args) {

    $parametros = $request->getParsedBody();
    $arquivos = 'arquivo/' . $parametros['repositorio'] . '/';
    $nome_arquivo = salvar_arquivo_base64($arquivos, $parametros['imagem']);

    return $nome_arquivo;

});

// ROTAS DE AÇÕES
$app->post("/upload/{repositorio}", function ($request, $response, $args) {

    if (isset($_COOKIE['parametros'])) {
        $parametros = json_decode($_COOKIE['parametros']);
    }

    $extensoes = array('jpeg', 'png', 'bmp', 'jpg');
    $extensao = strtolower(pathinfo($_FILES['file']['name'])['extension']);
    $destino = 'arquivo/' . $args['repositorio'] . '/';
    
    $nome = texto_identificador(str_replace(".$extensao", '', $_FILES['file']['name']));
    
    $arquivos = glob($destino . $nome . '*'. ".$extensao");
    $nome_arquivo = $nome . (count($arquivos) > 0 ? '-' . count($arquivos) : '') . ".$extensao";

    $nome_completo = $destino . $nome_arquivo;

    move_uploaded_file($_FILES['file']['tmp_name'], $nome_completo);

    $extensao = strtolower($extensao);

    if (in_array($extensao, $extensoes)) {
        if (in_array($extensao, array('jpg', 'jpeg'))) {
            if (function_exists('exif_read_data')) {
                $new_image = imagecreatefromjpeg($nome_completo);

                $exif = exif_read_data($nome_completo);

                if ($exif && isset($exif['Orientation'])) {
                    $orientation = $exif['Orientation'];
                    if ($orientation != 1) {
                        $deg = 0;
                        switch ($orientation) {
                            case 3:
                                $deg = 180;
                                break;
                            case 6:
                                $deg = -90;
                                break;
                            case 8:
                                $deg = 90;
                                break;
                        }
                        if ($deg) {
                            $new_image = imagerotate($new_image, $deg, 0);
                            imagejpeg($new_image, $nome_completo, 100);
                        }
                        // then rewrite the rotated image back to the disk as $filename
                    } // if there is some rotation necessary
                } // if have the exif orientation info
            }
        }
        
        list($width,$height,$type) = getimagesize($nome_completo);
        $width = intval($width/2);
        $width = $width > 1920 ? 1920 : $width;
        resizeImage($nome_completo, $width, $nome_completo);
    }

    $retorno = array('nome' => $nome_arquivo);

    return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($retorno));

});

$app->post("/{controlador}/{funcao}", function ($request, $response, $args) {

    $caminho = "../controller/" . $args["controlador"] . '.php';
    $nome_controller = arquivo_nome_real($caminho, true, false);
    $controller = "controller\\" . $nome_controller;

    $controller = new $controller;

    $retorno = $controller->{$args["funcao"]}($request->getParsedBody());

    return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($retorno));

});

$app->post("/{controlador}/{funcao}/text", function ($request, $response, $args) {

    $caminho = "../controller/" . $args["controlador"] . '.php';
    $nome_controller = arquivo_nome_real($caminho, true, false);
    $controller = "controller\\" . $nome_controller;

    $controller = new $controller;

    $controller->{$args["funcao"]}($request->getParsedBody());

    return $response->withStatus(200);

});

$app->post("/upload/{controlador}/{funcao}", function ($request, $response, $args) {

    global $_token;

    $id = (string)$_COOKIE["id"];

    $caminho = "../controller/" . $args["controlador"] . '.php';
    $nome_controller = arquivo_nome_real($caminho, true, false);
    $controller = "controller\\" . $nome_controller;

    $controller = new $controller;

    $paramentros = $request->getParsedBody();
    $paramentros["arquivo"] = $_FILES["file"];
    $paramentros["id"] = $id;

    $retorno = $controller->{$args["funcao"]}($paramentros);

    return $response->withStatus(200)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($retorno));

});

$app->run();


//$routes = $app->getContainer()->router->getRoutes();
//// And then iterate over $routes
//
//foreach ($routes as $route) {
//    echo $route->getPattern(), "<br>";
//}
