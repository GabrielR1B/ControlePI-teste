<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Redatores', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Novo Redator', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Editar Redator', true), array('action' => 'edit', $this->data['Redator']['id'])); ?> </li>
	</ul>
</div>

<h2><?php __('Edit Redator'); ?></h2>

<div class="areas form">
<?php echo $this->Form->create('Redator');?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('nome');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>