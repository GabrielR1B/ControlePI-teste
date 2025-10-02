<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Andamentos', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('Novo Andamento', true), array('action' => 'add')); ?></li>
	</ul>
</div>

<h2><?php __('Adicionar Andamento'); ?></h2>

<div class="status form">
<?php echo $this->Form->create('Andamento');?>
	<fieldset>
	<?php
		echo $this->Form->input('nome');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>