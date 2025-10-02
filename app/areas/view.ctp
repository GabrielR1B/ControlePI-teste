<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Areas', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Area', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Edit Area', true), array('action' => 'edit', $area['Area']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Area', true), array('action' => 'delete', $area['Area']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $area['Area']['id'])); ?> </li>
	</ul>
</div>

<div class="areas view">
<h2><?php  __('Area');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nome'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $area['Area']['nome']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nome em Inglês'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $area['Area']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>

<div class="related">
	<h2><?php __('Tecnologias Relacionadas');?></h2>
	<?php if (!empty($area['Tecnologia'])):?>
	
	<h3><?php printf(__('Foram encontradas <strong>%d</strong> tecnologias relacionadas.', true),count($area['Tecnologia'])) ?></h3>
		
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
		foreach ($area['Tecnologia'] as $tecnologia):
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
			<td><?php echo $tecnologia['Area']['nome'];?></td
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'tecnologias', 'action' => 'view', $tecnologia['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'tecnologias', 'action' => 'edit', $tecnologia['id'])); ?>
				<?php echo $this->Html->link(__('Excluir', true), array('controller' => 'tecnologias', 'action' => 'delete', $tecnologia['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $tecnologia['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php else: ?>
	<h3><?php __('Não foram encontradas tecnologias relacionadas com esta área.') ?></h3>
<?php endif; ?>
</div>
