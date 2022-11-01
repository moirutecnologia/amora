<?php
$produtos = \controller\Produto::_listar(); ?>
<option value="">Selecione</option>
<?php foreach ($produtos as $produto) { ?>
    <option value="<?php echo $produto->id; ?>" produto_id="<?php echo $produto->id; ?>"><?php echo $produto->nome; ?></option>
<?php } // foreach $produtos
?>