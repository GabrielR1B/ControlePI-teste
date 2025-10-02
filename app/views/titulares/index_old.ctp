<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Titulares', true), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Novo Titular', true), array('action' => 'add')); ?></li>
	</ul>
</div>
<div class="titulares index">
	<h2><?php __('Titulares');?></h2>
	
	<table class="simples" cellpadding="0" cellspacing="0">
	<tr>
		<th><?php echo "#";?></th>
		<th><?php echo "Titular"; $this->Paginator->sort('nome');?></th>
		<th class="actions"><?php __('');?></th>
	</tr>
	<?php
	$i = 0;
	$j = 0;
	$item = $this->Paginator->counter(array('format' => '%start%'));
	
	foreach ($titulares as $titular):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td class="id"><?php echo $item + $j++; ?></td>
		<td><?php echo $titular['Titular']['nome']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $titular['Titular']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $titular['Titular']['id'])); ?>
			<?php echo $this->Html->link(__('Excluir', true), array('action' => 'delete', $titular['Titular']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $titular['Titular']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	  	<?php echo $this->Paginator->numbers();?>
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>