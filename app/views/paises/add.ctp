<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Países', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Adicionar País', true), array('action' => 'add')); ?> </li>
	</ul>
</div>

<div class="paises form">
<h2><?php __('Adicionar País'); ?></h2>	
<?php echo $this->Form->create('Pais');?>
	<fieldset>
	<?php
		echo $this->Form->input('nome');
		echo $this->Form->input('sigla');
		echo $this->Form->input('arquivo');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>