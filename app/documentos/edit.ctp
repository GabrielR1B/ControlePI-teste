<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Areas', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('New Area', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('excluir Área', true), array('action' => 'delete', $this->Form->value('Area.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Area.id'))); ?></li>
	</ul>
</div>

<h2><?php __('Editar Tipo de Documento'); ?></h2>

<div class="documentos form">
<?php echo $this->Form->create('Documento');?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('nome');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>