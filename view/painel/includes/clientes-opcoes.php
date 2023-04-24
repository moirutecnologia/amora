<?php
$clientes = \controller\Cliente::_listar(); ?>
<option value="">Selecione</option>
<?php foreach ($clientes as $cliente) { ?>
    <option value="<?php echo $cliente->id; ?>" <?php echo $cliente->id == ($_GET['cliente_id'] ?? '') ? 'selected' : ''; ?>><?php echo $cliente->nome; ?></option>
<?php } // foreach $clientes 
?>