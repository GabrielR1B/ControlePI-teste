<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Países', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Adicionar País', true), array('action' => 'add')); ?> </li>
	</ul>
</div>

<div class="despachos form">
<h2><?php __('Adicionar Despacho'); ?></h2>	
<?php echo $this->Form->create('Despacho');?>
	<fieldset>
	<?php
		echo $this->Form->input('codigo', array('type'=>'text'));
		echo $this->Form->input('titulo');
		echo $this->Form->input('requer_acao', array('label'=>'Requer ação'));
	?>
	<div id="prazo" class="input text" style="display: block; display: none;">
		<label for="DespachoPrazo">Prazo</label>
		<input name="data[Despacho][prazo]" type="text" maxlength="11" id="DespachoPrazo">
	</div>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#DespachoRequerAcao').change(function(){
			if($(this).is(":checked")){
				$('#prazo').show();
			}else{
				$('#prazo').hide();
				$('#DespachoPrazo').val('');
			}

			
		});
	});
</script>