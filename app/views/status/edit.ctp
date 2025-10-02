<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Status', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('New Status', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('excluir Status', true), array('action' => 'delete', $this->Form->value('Status.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Status.id'))); ?></li>
		
	</ul>
</div>

<h2><?php __('Edit Status'); ?></h2>
<div class="situacoes form">
<?php echo $this->Form->create('Status');?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('nome');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
