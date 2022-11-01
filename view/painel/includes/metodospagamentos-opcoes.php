<?php $metodospagamentos = \controller\MetodoPagamento::_listar(); ?>
<option value="">Selecione</option>
<?php foreach ($metodospagamentos as $metodopagamento) { ?>
    <option value="<?php echo $metodopagamento->id; ?>" <?php echo $metodopagamento->id == $produto->marca_id ? 'selected' : ''; ?>><?php echo $metodopagamento->nome; ?></option>
<?php } // foreach $metodospagamentos 
?>