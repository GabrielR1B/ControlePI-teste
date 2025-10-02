<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Empresas', true), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Nova Empresa', true), array('action' => 'add')); ?></li>
	</ul>
</div>

<div class="empresas index">
	<h2><?php __('Empresas');?></h2>
	
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
	
	<table class="simples" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php __('#');?></th>
			<th><?php echo $this->Paginator->sort('nome');?></th>
			<th class="actions"><?php __('');?></th>
	</tr>
	<?php
	$i = 0;
	$j = 0;
	$item = $this->Paginator->counter(array('format' => '%start%'));
	
	foreach ($empresas as $empresa):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td class="id"><?php echo $item + $j++; ?></td>
		<td>
			<p><?php echo $empresa['Empresa']['nome']; ?></p>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $empresa['Empresa']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $empresa['Empresa']['id'])); ?>
			<?php echo $this->Html->link(__('Excluir', true), array('action' => 'delete', $empresa['Empresa']['id']), null, sprintf(__('Tem certeza que deseja remover a empresa %s?', true), $empresa['Empresa']['nome'])); ?>
		</td>
	</tr>
	<?php endforeach; ?>
	</table>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
	
</div>