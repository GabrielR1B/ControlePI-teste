<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Titulares', true), array('action' => 'index')); ?></li>
	</ul>
</div>

<div class="titulares form">
<h2><?php __('Adicionar Titular');?></h2>
	
	
<?php echo $this->Form->create('Titular');?>
	<fieldset>
	<?php
		echo $this->Form->input('nome',array('label'=>__('Nome',true) ));
		echo $this->Form->input('cnpj',array('label'=>'CNPJ'));
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