<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('New Status', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Edit Status', true), array('action' => 'edit', $andamento['Andamento']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Status', true), array('action' => 'delete', $andamento['Andamento']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $andamento['Andamento']['id'])); ?> </li>
	</ul>
</div>

<div class="view">
<h2><?php 
	if($andamento['Andamento']['id']!=1){
		echo "Patentes ".$andamento['Andamento']['nome']."s";
	}else{
		echo "Patentes ".$andamento['Andamento']['nome'];
	}

	?></h2>
</div>

<div class="related">
	<?php if (!empty($tecnologias)):?>
		
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>	

	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('#'); ?></th>
		<th><?php echo $this->Paginator->sort('titulo'); ?></th>
		<th><?php echo $this->Paginator->sort('num_pedido'); ?></th>
		<th><?php echo $this->Paginator->sort('data');?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($tecnologias as $tecnologia):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td class="id"><?php echo $j++; ?></td>
			<td class="titulo_tecnologia"><?php echo $tecnologia['Tecnologia']['titulo'];?></td>
			<td class="num_pedido"><?php echo $tecnologia['Tecnologia']['num_pedido'];?></td>
			<td class="data"><?php echo $time->format('d.m.Y', $tecnologia['Tecnologia']['data']); ?>&nbsp;</td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'tecnologias', 'action' => 'view', $tecnologia['Tecnologia']['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'tecnologias', 'action' => 'edit', $tecnologia['Tecnologia']['id'])); ?>
				<?php echo $this->Html->link(__('Excluir', true), array('controller' => 'tecnologias', 'action' => 'delete', $tecnologia['Tecnologia']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $tecnologia['Tecnologia']['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php else: ?>
	<h3><?php __('Não foram encontradas tecnologias relacionadas com esta situação.') ?></h3>
<?php endif; ?>

</div>
