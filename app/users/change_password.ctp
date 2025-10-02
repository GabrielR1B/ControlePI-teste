<?php echo $this->Form->create();
	echo $this->Form->input( 'id', array( 'value' => $id  , 'type' => 'hidden') ); 
	echo $this->Form->input('current_password',array('type'=>'password'));
	echo $this->Form->input('password',array('label'=>'New password', 'type'=>'password','value'=>''));
	echo $this->Form->input('password_confirmation',array('label'=>'confirm your password','type'=>'password', 'value'=>''));
	echo $this->Form->end('change');
?>