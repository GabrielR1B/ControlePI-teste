<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Escritórios', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('Novo Escritório', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Excluir Escritório', true), array('action' => 'delete', $this->Form->value('Escritorio.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Escritorio.id'))); ?></li>
	</ul>
</div>

<h2><?php __('Editar Escritório'); ?></h2>
<div class="situacoes form">
<?php echo $this->Form->create('Escritorio');?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('nome');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
