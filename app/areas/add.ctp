<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Areas', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('New Area', true), array('action' => 'add')); ?></li>
	</ul>
</div>

<div class="areas form">
<h2><?php __('Add Area'); ?></h2>	
<?php echo $this->Form->create('Area');?>
	<fieldset>
	<?php
		echo $this->Form->input('nome');
		echo $this->Form->input('name',array('label'=>'Nome em Inglês'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>