<?php $investimentostipos = \controller\InvestimentoTipo::_listar(); ?>
<option value="">Selecione</option>
<?php foreach ($investimentostipos as $$investimentotipo) { ?>
    <option value="<?php echo $$investimentotipo->id; ?>"><?php echo $$investimentotipo->nome; ?></option>
<?php } // foreach $investimentostipos 
?>