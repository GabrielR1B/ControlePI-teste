<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(('Novo Knowhow'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(('Buscar Knowhow'), array('action' => 'search')); ?></li>
	</ul>
</div>

<div class="knowhows index">
	<h2>Knowhow</h2>	
	<p><?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	)); ?></p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>

	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('pasta');?></th>
			<th><?php echo $this->Paginator->sort('titulo');?></th>
			<th><?php echo $this->Paginator->sort('data');?></th>
			<th class="actions"><?php __('');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($knowhows as $knowhow):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $knowhow['Knowhow']['pasta']; ?>&nbsp;</td>
		<td><?php echo $knowhow['Knowhow']['titulo']; ?>&nbsp;</td>
		<td><?php echo $time->format('d.m.Y',$knowhow['Knowhow']['data']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $knowhow['Knowhow']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $knowhow['Knowhow']['id'])); ?>
			<?php echo $this->Html->link(__('Excluir', true), array('action' => 'delete', $knowhow['Knowhow']['id']), null, sprintf(('Você tem certeza de que deseja excluir o knowhow "%s"?'), $knowhow['Knowhow']['titulo'])); ?>
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