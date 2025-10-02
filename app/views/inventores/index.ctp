<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Inventores', true), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('New Inventor', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Buscar Inventores', true), array('action' => 'search')); ?></li>
		<li><?php echo $this->Html->link(__('Listar inventores por núm. tecnologias', true), array('action' => 'listar')); ?></li>
	</ul>
</div>

<div class="inventores index">
	<h2><?php __('Inventores');?></h2>
	
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
	
	foreach ($inventores as $inventor):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td class="id"><?php echo $item + $j++; ?></td>
		<td>
			<p><?php echo $inventor['Inventor']['nome']; ?></p>
			<p style="color:#888;font-size:11px">Número de tecnologias: <?php echo count($inventor['Tecnologia']); ?></p>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $inventor['Inventor']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $inventor['Inventor']['id'])); ?>
			<?php echo $this->Html->link(__('Excluir', true), array('action' => 'delete', $inventor['Inventor']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $inventor['Inventor']['id'])); ?>
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