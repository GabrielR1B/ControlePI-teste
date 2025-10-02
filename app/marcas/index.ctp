<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Marcas', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nova Marca', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Buscar Marca', true), array('action' => 'search')); ?></li>
	</ul>
</div>

<div class="marcas index">
	<h2><?php __('Marcas');?></h2>
	
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
			<th><?php echo $this->Paginator->sort('nome');?></th>
			<th> processo </th>
			<th> pasta </th>
			<th><?php echo $this->Paginator->sort('data');?></th>
			<th class="actions"><?php __('');?></th>
	</tr>
	<?php
	$i = 0;
	$j = 0;
	$item = $this->Paginator->counter(array('format' => '%start%'));
	foreach ($marcas as $marcas):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>	
	<tr<?php echo $class;?>>
		<td class="id"><?php echo $item + $j++; ?></td>
		
		<td class="nome_marca">
			
			<?php 
			echo $this->Html->link(
				$marcas['Marca']['nome'],
				array('action' => 'view', $marcas['Marca']['id']),
				array('class' => 'marca')
				);
			 ?>
		</td>
		
		<td class="processo">
			<?php
				if(!$marcas['Marca']['pasta']) {
					$marcas['Marca']['pasta'] = '-';
				}
			?>
			<?php printf( '<p>%s</p>', $marcas['Marca']['processo']) ?>&nbsp;
		</td>
		<td> <?php printf('<p>%s</p>', $marcas['Marca']['pasta']) ?></td>
		
		<td class="data"><?php echo $time->format('d.m.Y', $marcas['Marca']['data']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $marcas['Marca']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $marcas['Marca']['id'])); ?>
			<?php echo $this->Html->link(__('Excluir', true), array('action' => 'delete', $marcas['Marca']['id']), null, sprintf(__('Tem certeza que deseja excluir esta tecnologia?', true), $marcas['Marca']['id'])); ?>
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