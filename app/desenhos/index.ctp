<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Novo DI', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Buscar DI', true), array('action' => 'search')); ?></li>
	</ul>
</div>

<div class="desenhos index">
	<h2><?php __('Desenhos Industriais');?></h2>
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
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php __('#');?></th>
			<th><?php echo $this->Paginator->sort('Título','titulo');?></th>
			<th><?php echo $this->Paginator->sort('Número do pedido','num_pedido');?></th>
			<th><?php echo $this->Paginator->sort('pasta');?></th>
			<th><?php echo $this->Paginator->sort('data');?></th>
			<th><?php echo $this->Paginator->sort('area_id');?></th>
			<th class="actions"><?php __('');?></th>
	</tr>
	<?php
	$i = 0;
	$j = 0;
	$item = $this->Paginator->counter(array('format' => '%start%'));
	foreach ($desenhos as $desenho):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td class="id"><?php echo $item + $j++; ?></td>
		<td><?php echo $desenho['Desenho']['titulo']; ?>&nbsp;</td>
		<td><?php echo $desenho['Desenho']['num_pedido']; ?>&nbsp;</td>
		<td><?php echo $desenho['Desenho']['pasta']; ?>&nbsp;</td>	
		<td><?php echo $time->format('d.m.Y',$desenho['Desenho']['data']); ?>&nbsp;</td>	
		<td>
			<?php echo $this->Html->link($desenho['Area']['nome'], array('controller' => 'areas', 'action' => 'view', $desenho['Area']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $desenho['Desenho']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $desenho['Desenho']['id'])); ?>
			<?php echo $this->Html->link(__('Excluir', true), array('action' => 'delete', $desenho['Desenho']['id']), null, sprintf(__('Você tem certeza de que deseja deletar o desenho industrial intitulado: %s?', true), $desenho['Desenho']['titulo'])); ?>
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
