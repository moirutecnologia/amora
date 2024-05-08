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
        'data_de' => date('Y-m-d', strtotime('-20 year')),
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

    // var_dump($clientes);

    foreach ($clientes as $cliente) {
        $mensagem = "Oi, $cliente[cliente]. Tudo bem?\nVi que algum produto que comprou comigo pode estar acabando.👇\n\n" . implode("\n", $cliente['produtos']) . "\n\nQualquer coisa chama tá!😉\n\n👉 Para sua primeira compra on-line Natura, coloque o cupom PRIMEIRACOMPRA e terá um desconto extra de 20% em natura.com.br/consultoria/simonectj.";

        $dados = array(
            'para' => '55' . $cliente['whatsapp'],
            'mensagem' => $mensagem
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://whatsapp.moiru.com.br/api/enviar',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($dados),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer 88d3fdaf072c50203f38550425a4410c56ae80f05c1ff52efc33b8b855e03930'
            ),
        ));

        curl_exec($curl);

        curl_close($curl);

        // echo $mensagem . '<hr>';
    }

    // var_dump(array_column($clientes, 'cliente_id'));

});

$app->get('/agendar/whatsapp-recompra-usuarios', function ($request, $response, $args) {
    
    $model = new \model\_BaseModel();

    $model->executar("CREATE TEMPORARY TABLE ultimas_vendas
    SELECT
        sv.data,
        svp.produto_id,
        sv.cliente_id,
        c.whatsapp,
        m.nome AS marca,
        p.nome AS produto,
        c.nome AS cliente,
        m.enviar_whatsapp
    FROM vendas_produtos AS svp
    INNER JOIN vendas AS sv
        ON svp.venda_id = sv.id
    INNER JOIN clientes AS c
        ON sv.cliente_id = c.id
    INNER JOIN produtos AS p
        ON svp.produto_id = p.id
    INNER JOIN marcas AS m
        ON p.marca_id = m.id
    WHERE
        sv.usuario_id = '13'
        AND ('2014-05-06' = '1900-01-01' OR sv.data >= '2014-05-06')
        AND ('6000-01-01 23:59:59' = '6000-01-01 23:59:59' OR sv.data <= '6000-01-01 23:59:59');");
    
    $model->executar("create index idx_produto_id ON ultimas_vendas(produto_id);");
    $model->executar("create index idx_data ON ultimas_vendas(data);");
    $model->executar("create index idx_cliente ON ultimas_vendas(cliente_id);");
    $model->executar("create index idx_venda ON ultimas_vendas(produto_id, cliente_id, data);");
    
    $model->executar("CREATE TEMPORARY TABLE ultimas_vendas_produtos
    SELECT * FROM ultimas_vendas;");

    $model->executar("create index idx_produto_id_2 ON ultimas_vendas_produtos(produto_id);");
    $model->executar("create index idx_data_2 ON ultimas_vendas_produtos(data);");
    $model->executar("create index idx_cliente_2 ON ultimas_vendas_produtos(cliente_id);");
    $model->executar("create index idx_venda_2 ON ultimas_vendas_produtos(produto_id, cliente_id, data);");
    
    $model->executar("CREATE TEMPORARY TABLE produto_datas
    SELECT
        uv.cliente,
        uv.produto,
        uv.marca,
        uv.cliente_id,
        uv.whatsapp,
        uv.enviar_whatsapp,
        (
            SELECT
                MAX(suvp.data)
            FROM ultimas_vendas_produtos AS suvp
            WHERE
                suvp.produto_id = uv.produto_id
                AND suvp.cliente_id = uv.cliente_id
                AND suvp.data < uv.data
            GROUP BY suvp.produto_id
            LIMIT 1
        ) AS anterior,
        uv.data AS ultima,
        uv.produto_id
    FROM ultimas_vendas AS uv
    ORDER BY uv.data;");
    
    $clientes = $model->obterLista("SELECT
                                        d.cliente_id,
                                        d.cliente,
                                        d.whatsapp,
                                        CONCAT(d.marca , ' - ', d.produto) AS produto,
                                        ROUND(AVG(DATEDIFF(ultima, anterior)),0) AS media,
                                        DATEDIFF(now(), MAX(ultima)) AS ultima,
                                        (ROUND(AVG(DATEDIFF(ultima, anterior)),0) - DATEDIFF(now(), MAX(ultima))) - 15 AS alerta,
                                        AVG(DATEDIFF(ultima, anterior)) - DATEDIFF(now(), MAX(ultima)) AS ordem    
                                    FROM produto_datas AS d
                                    WHERE
                                        d.anterior IS NOT NULL
                                        AND ('1' = '' OR d.enviar_whatsapp = '1')
                                        AND d.whatsapp IS NULL
                                    GROUP BY
                                        d.cliente_id,
                                        d.cliente,
                                        d.whatsapp,
                                        d.marca,
                                        d.produto
                                    HAVING
                                        (ROUND(AVG(DATEDIFF(ultima, anterior)),0) - DATEDIFF(now(), MAX(ultima))) >= 15
                                    ORDER BY 
                                        (ROUND(AVG(DATEDIFF(ultima, anterior)),0) - DATEDIFF(now(), MAX(ultima)))");

    // foreach($clientes as $cliente){
    //     echo $cliente->cliente . '/' . $cliente->produto . ' / Alerta em ' . $cliente->alerta  . '<br>';
    // }

    echo implode('<br>', array_unique(array_column($clientes, 'cliente')));
});
