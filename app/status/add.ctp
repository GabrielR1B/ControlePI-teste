<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Status', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('New Status', true), array('action' => 'add')); ?></li>
	</ul>
</div>

<h2><?php __('Add Status'); ?></h2>

<div class="status form">
<?php echo $this->Form->create('Status');?>
	<fieldset>
	<?php
		echo $this->Form->input('nome');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>