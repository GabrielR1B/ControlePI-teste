<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Redatores', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Adicionar Redator', true), array('action' => 'add')); ?> </li>
	</ul>
</div>

<div class="redatores form">
<h2><?php __('Adicionar Redator'); ?></h2>	
<?php echo $this->Form->create('Redator');?>
	<fieldset>
	<?php
		echo $this->Form->input('nome');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>