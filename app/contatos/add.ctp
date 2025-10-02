<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Contatos', true), array('action' => 'index')); ?> </li>
	</ul>
</div>

<div class="marcas form">
<h2><?php __('Adicionar Contato');?></h2>
	
<?php echo $this->Form->create('Contato');?>
	<fieldset>
		<?php
			echo $this->Form->input('nome', array('type' => 'text'));
			echo $this->Form->input('departamento', array('type' => 'text'));
			echo $this->Form->input('unidade', array('type' => 'text'));
			echo $this->Form->input('telefones', array('type' => 'text'));
			echo $this->Form->input('email', array('type' => 'text'));
			echo $this->Form->input('endereco', array('type' => 'text'));
		?>
	</fieldset>
	
<?php echo $this->Form->end(__('Submit', true));?>
</div>