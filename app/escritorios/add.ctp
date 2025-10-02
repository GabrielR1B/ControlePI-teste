<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Escritorio', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('New Escritorio', true), array('action' => 'add')); ?></li>
	</ul>
</div>

<h2><?php __('Adicionar Escritório'); ?></h2>

<div class="escritorio form">
<?php echo $this->Form->create('Escritorio');?>
	<fieldset>
	<?php
		echo $this->Form->input('nome');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>