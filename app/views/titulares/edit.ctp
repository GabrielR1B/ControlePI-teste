<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Titulares', true), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Novo Titular', true), array('action' => 'add')); ?></li>
	</ul>
</div>

<div class="titulares form">
	<?php echo $this->Form->create('Titular');?>
	<fieldset>
		<legend><?php __('Editar Titular'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('nome');
		echo $this->Form->input('cnpj');
		echo $this->Form->input('contatos');
	?>
	</fieldset>
	<?php echo $this->Form->end(__('Submit', true));?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#TitularCnpj").mask("99.999.999/9999-99");
	});
</script>