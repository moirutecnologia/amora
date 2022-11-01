<?php
$produtoMarcaId = $produto->marca_id ?? 0;
$marcas = \controller\Marca::_listar();
?>
<option value="">Selecione</option>
<?php foreach ($marcas as $marca) { ?>
    <option value="<?php echo $marca->id; ?>" <?php echo $marca->id == $produtoMarcaId || $marca->id == ($_GET['marca_id'] ?? '') ? 'selected' : ''; ?>><?php echo $marca->nome; ?></option>
<?php } // foreach $marcas 
?>