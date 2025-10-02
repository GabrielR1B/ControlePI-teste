<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Palavras-chave', true), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Nova Palavra-chave', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Buscar Palavra-Chave', true), array('action' => 'search')); ?></li>
		<li><?php echo $this->Html->link(__('Listar número de tecnologias por palavra-chave', true), array('action' => 'listar')); ?></li>
	</ul>
</div>

<div class="palavraschave index">
	<h2><?php __('Palavras-chave');?></h2>

<table cellpadding = "0" cellspacing = "0">
	<?php $i = 0; $class = ' class="altrow"';?>
	<tr>
		<td style="width:100px"><?php __('Nome'); ?></td>
		<td><?php echo $palavrachave['Palavrachave']['palavra']; ?></td>
	</tr>
</table>
</div>

<div class="related">
	<h2><?php __('Tecnologias Relacionadas');?></h2>
	<?php if (!empty($palavrachave['Tecnologia'])):?>
	<h3><?php printf(__('Foram encontradas <strong>%d</strong> tecnologias relacionadas.', true),count($palavrachave['Tecnologia'])) ?></h3>
	
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('#'); ?></th>
		<th><?php __('Titulo'); ?></th>
		<th><?php __('Núm Pedido'); ?></th>
		<th><?php __('Data'); ?></th>
		<th><?php __('Área'); ?></th>
		<th><?php __('Situação'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($palavrachave['Tecnologia'] as $tecnologia):
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
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'tecnologias', 'action' => 'view', $tecnologia['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'tecnologias', 'action' => 'edit', $tecnologia['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php else: ?>
	<h3><?php __('Não foram encontradas tecnologias relacionadas com esta palavra-chave.') ?></h3>
<?php endif; ?>
</div>
