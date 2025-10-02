<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Andamentos', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('Novo Andamento', true), array('action' => 'add')); ?></li>	
	</ul>
</div>

<h2><?php __('Editar Andamento'); ?></h2>
<div class="situacoes form">
<?php echo $this->Form->create('Andamento');?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('nome');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
