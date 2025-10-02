<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Tipos de Documento', true), array('action' => 'index'));?></li>
	</ul>
</div>

<div class="areas form">
<h2><?php __('Adicionar Tipo de Documento'); ?></h2>	
<?php echo $this->Form->create('Documento');?>
	<fieldset>
	<?php
		echo $this->Form->input('nome');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>