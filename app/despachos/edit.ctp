<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Países', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Adicionar País', true), array('action' => 'add')); ?> </li>
	</ul>
</div>

<div class="despachos form">
<h2><?php __('Editar Despacho'); ?></h2>	
<?php echo $this->Form->create('Despacho');?>
	<fieldset>
	<?php
		echo $this->Form->input('codigo', array('type'=>'text'));
		echo $this->Form->input('titulo');
		echo $this->Form->input('requer_acao', array('label'=>'Requer ação'));
		echo $this->Form->input('prazo');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>