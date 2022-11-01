<?php
$arquivo = arquivo_nome_real("../view/painel/$pagina.php");

include "../view/template/CabecalhoImprimir.php";
include $arquivo;
include "../view/template/RodapeImprimir.php";
