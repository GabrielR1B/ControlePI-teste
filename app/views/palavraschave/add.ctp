<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Palavras-chave', true), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Nova Palavra-chave', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Buscar Palavra-Chave', true), array('action' => 'search')); ?></li>
		<li><?php echo $this->Html->link(__('Listar número de tecnologias por palavra-chave', true), array('action' => 'listar')); ?></li>
	</ul>
</div>

<div class="palavraschave form">
<h2><?php __('Adicionar Palavra-chave');?></h2>
	
	
<?php echo $this->Form->create('Palavrachave');?>
	<fieldset>
	<?php
		echo $this->Form->input('palavra',array('label'=>__('Palavra-chave',true) ));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>