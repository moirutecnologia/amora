<?php
global $_usuario;

$arquivo = arquivo_nome_real("../view/$pagina.php");
$arquivonome = arquivo_nome_real("../view/$pagina.php", true, false);

global $_paginas;
global $_cabecalho_padrao;
global $_rodape_padrao;

$cabecalho = $_cabecalho_padrao;
$rodape = $_rodape_padrao;

$indice = array_search(strtolower($pagina), array_column($_paginas, "pagina"));

if($indice !== false){
    $cabecalho =  $_paginas[$indice]["cabecalho"] ?? $cabecalho;
    $rodape =  $_paginas[$indice]["rodape"] ?? $rodape;
}

if($arquivonome == '404' || empty($arquivonome)){
    $cabecalho = 'CabecalhoSite';
    $arquivo = '../view/Inicio.php';
    $rodape = 'RodapeSite';
    $pagina = 'Inicio';
}

include "../view/template/{$cabecalho}.php";
include $arquivo;
include "../view/template/{$rodape}.php";
