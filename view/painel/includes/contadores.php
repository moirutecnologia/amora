<?php
global $_usuario;

$parametros['data_de'] = $parametros['data_de'] ?? ($_usuario->assinante ? date('Y') . '-01-01' : date('Y-m-d', strtotime('-2 months')));

$contadores = new \controller\Usuario();
$contadores = $contadores->contadores($parametros);

$saldos = new \controller\Pagamento();
$saldos = $saldos->listarSaldo($parametros);

$receber = 0;

foreach ($saldos as $saldo) {
    if ($saldo->saldo < 0) {
        $receber += $saldo->saldo;
    }
}

$ganhos = new \controller\Venda();
$ganhos = $ganhos->listarGraficoGanhos($parametros);

$media = 0;
foreach ($ganhos as $ganho) {
    $media += $ganho->total;
}

$media = $media != 0 ? $media / count($ganhos) : 0;

?>
<div class="columns is-mobile is-centered is-multiline contadores">
    <div class="column is-6-mobile has-text-centered">
        <div>
            <p class="heading">Clientes ativos</p>
            <p class="title is-4"><?php echo $contadores->clientes; ?></p>
        </div>
    </div>
    <div class="column is-6-mobile has-text-centered">
        <div>
            <p class="heading">Vendas</p>
            <p class="title is-4"><span>R$ </span><?php echo mask($contadores->vendas, '$'); ?></p>
        </div>
    </div>
    <div class="column is-6-mobile has-text-centered">
        <div>
            <p class="heading">Investimentos</p>
            <p class="title is-4"><span>R$ </span><?php echo mask($contadores->investimento, '$'); ?></p>
        </div>
    </div>
    <div class="column is-6-mobile has-text-centered">
        <div>
            <p class="heading">Recebidos</p>
            <p class="title is-4"><span>R$ </span><?php echo mask($contadores->recebido, '$'); ?></p>
        </div>
    </div>
    <div class="column is-6-mobile has-text-centered">
        <div>
            <p class="heading">Ganho médio mensal</p>
            <p class="title is-4"><span>R$ </span><?php echo mask($media, '$'); ?></p>
        </div>
    </div>
    <div class="column is-6-mobile has-text-centered receber">
        <a href="/painel/saldo">
            <div>
                <p class="heading">Valor para receber</p>
                <p class="title is-4"><span>R$ </span><?php echo mask(abs($receber), '$'); ?></p>
            </div>
        </a>
    </div>
</div>