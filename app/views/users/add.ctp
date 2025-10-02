<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar', true), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('New User', true), array('action' => 'add')); ?></li>
	</ul>
</div>

<?php
echo $this->Form->create();
echo $this->Form->input('username');
echo $this->Form->input('password', array('value'=>''));
echo $this->Form->input('password_confirmation',array('type'=>'password'));
echo $this->Form->input('first_name');
echo $this->Form->input('last_name');
echo $this->Form->input('email');
echo $this->Form->input('group_id');
echo $this->Form->end('Submit');
?>