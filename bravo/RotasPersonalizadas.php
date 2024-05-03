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

    foreach ($usuarios as $usuario) {
        enviaremail($usuario->email, 'Amora', 'Conheça a Amora', 'Conheca', array());
    }

    echo 'foi!';
});

$app->get('/agendar/whatsapp-recompra', function ($request, $response, $args) {
    $clientesController = new \controller\Cliente;
    $produtos = $clientesController->listarRelatorioIntervaloCompraProduto(array(
        'data_de' => date('Y-m-d', strtotime('-10 year')),
        'dias_media_ultima' => 15,
        'whatsapp_not_null' => 1,
        'enviar_whatsapp' => 1,
        'usuario_id' => 13,
    ));

    $clientes = array();

    foreach ($produtos as $produto) {
        $clientes[$produto->cliente_id] ??= array('cliente' => explode(' ', $produto->cliente)[0], 'whatsapp' => $produto->whatsapp, 'produtos' => array());
        $clientes[$produto->cliente_id]['produtos'][] = $produto->produto;
    }

    foreach ($clientes as $cliente) {
        $mensagem = "Oi, $cliente[cliente]. Tudo bem? Vi que alguns produtos que comprou comigo podem estar acabando. Qualquer coisa me chama, tá?\n" . implode("\n", $cliente['produtos']);

        $dados = array(
            'para' => '5554996766177',
            'mensagem' => $mensagem
        );

        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'https://whatsapp.moiru.com.br/api/enviar',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_POSTFIELDS => json_encode($dados),
        //     CURLOPT_HTTPHEADER => array(
        //         'Content-Type: application/json',
        //         'Authorization: Bearer fca9901fab3d632b57f3dada73e9d2fc8a7a1c1dfae6d13944db82561b547204'
        //     ),
        // ));

        // curl_exec($curl);

        // curl_close($curl);

        echo $mensagem . '<hr>';
    }

    // var_dump(array_column($clientes, 'cliente_id'));

});
