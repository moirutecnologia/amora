<?php
$produto = \controller\Produto::_obter($parametros['produto_id']);

$produtosskus = \controller\ProdutoSKU::_listar(
    array(
        'produto_id' => $parametros['produto_id'],
        'em_estoque' => 1,
    )
);

foreach ($parametros['produtos'] as $produto_pedido) {
    if (empty($produto_pedido['produtosku_id']) && $produto_pedido['produto_id'] == $produto->id) {
        $produto->quantidade -= $produto_pedido['quantidade'];
    }
}

?>
<option value="" selecione>Selecione</option>
<?php if (!$parametros['aguardadoentrega']) { ?>
    <option entregue="0" produtosku_id="" minimo="1" maximo="9999999" preco="<?php echo $produto->preco; ?>">Não entregue</option>
<?php } // if $parametros['aguardadoentrega'] != 'aguardandoentrega' 
?>
<?php if ($produto->quantidade > 0) { ?>
<option entregue="1" produtosku_id="" minimo="1" maximo="<?php echo $produto->quantidade; ?>" preco="<?php echo $produto->preco; ?>">Entregue com estoque <?php echo $produto->quantidade; ?></option>
<?php } // if $produto->quantidade > 0
?>
<?php
foreach ($produtosskus as $produtosku) {
    foreach ($parametros['produtos'] as $produto_pedido) {
        if ($produto_pedido['produtosku_id'] == $produtosku->id) {
            $produtosku->quantidade -= $produto_pedido['quantidade'];
        }
    }

    if ($produtosku->quantidade > 0) { ?>
        ?>
        <option entregue="1" produtosku_id="<?php echo $produtosku->id; ?>" minimo="1" maximo="<?php echo $produtosku->quantidade; ?>" preco="<?php echo $produto->preco; ?>">Entregue com estoque R$ <?php echo mask($produtosku->preco, '$'); ?> (<?php echo $produtosku->quantidade; ?>)</option>
<?php
    } // if $produtosku->quantidade > 0
} // foreach $produtosskus
?>
<option entregue="1" produtosku_id="" minimo="1" maximo="9999999" preco="<?php echo $produto->preco; ?>">Entregue sem estoque</option>