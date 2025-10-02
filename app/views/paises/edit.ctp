<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Países', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Novo País', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Editar País', true), array('action' => 'edit', $this->data['Pais']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Deletar País', true), array('action' => 'delete', $this->data['Pais']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->data['Pais']['id'])); ?> </li>
	</ul>
</div>

<h2><?php __('Edit País'); ?></h2>

<div class="areas form">
<?php echo $this->Form->create('Pais');?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('nome');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>