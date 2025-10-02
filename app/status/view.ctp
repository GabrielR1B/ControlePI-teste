<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('New Status', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Edit Status', true), array('action' => 'edit', $status['Status']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Status', true), array('action' => 'delete', $status['Status']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $status['Status']['id'])); ?> </li>
	</ul>
</div>

<div class="situacoes view">
<h2><?php  __('Status');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nome'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $status['Status']['nome']; ?>
			&nbsp;
		</dd>
	</dl>
</div>

<div class="related">
	<h2><?php __('Tecnologias Relacionadas');?></h2>
	<?php if (!empty($status['Tecnologia'])):?>
		
	<h3><?php printf(__('Foram encontradas <strong>%d</strong> tecnologias relacionadas.', true),count($status['Tecnologia'])) ?></h3>		

	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('#'); ?></th>
		<th><?php __('Titulo'); ?></th>
		<th><?php __('Núm Pedido'); ?></th>
		<th><?php __('Data'); ?></th>
		<th><?php __('Área'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($status['Tecnologia'] as $tecnologia):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td class="id"><?php echo $j++; ?></td>
			<td class="titulo_tecnologia"><?php echo $tecnologia['titulo'];?></td>
			<td class="num_pedido"><?php echo $tecnologia['num_pedido'];?></td>
			<td class="data"><?php echo $time->format('d.m.Y', $tecnologia['data']); ?>&nbsp;</td>
			<td><?php echo $tecnologia['Area']['nome'];?></td>
			<td><?php echo $tecnologia['Status']['nome'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'status', 'action' => 'view', $tecnologia['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'status', 'action' => 'edit', $tecnologia['id'])); ?>
				<?php echo $this->Html->link(__('Excluir', true), array('controller' => 'status', 'action' => 'delete', $tecnologia['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $tecnologia['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php else: ?>
	<h3><?php __('Não foram encontradas tecnologias relacionadas com esta situação.') ?></h3>
<?php endif; ?>

</div>
