<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar', true), array('action' => 'index ')); ?></li>
		<li><?php echo $this->Html->link(__('New User', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Mudar Senha', true), array('action' => 'changePassword', $id)); ?></li>
	</ul>
</div>

<h2><?php __('Edit User'); ?></h2>

<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('email');	
		echo $this->Form->input('group_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>