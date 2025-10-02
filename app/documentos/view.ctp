<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Documentos', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Documento', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Edit Documento', true), array('action' => 'edit', $documento['Documento']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Documento', true), array('action' => 'delete', $documento['Documento']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $documento['Documento']['id'])); ?> </li>
	</ul>
</div>

<div class="documentos view">
<h2><?php  __('Documento');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nome'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $documento['Documento']['nome']; ?>
			&nbsp;
		</dd>
	</dl>
</div>