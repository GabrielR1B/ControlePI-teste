<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Editar Titular', true), array('action' => 'edit', $titular['Titular']['id'])); ?></li>
		<li><?php echo $this->Html->link(__('Listar Titulares', true), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Novo Titular', true), array('action' => 'add')); ?></li>
	</ul>
</div>

<div class="titulares view">
<h2><?php  __('Titular');?></h2>

<table cellpadding = "0" cellspacing = "0">
	<tr class="altrow">
		<td style="width:100px"><?php __('Nome'); ?></td>
		<td><?php echo $titular['Titular']['nome']; ?></td>
	</tr>
	<tr>
		<td style="width:100px"><?php __('CNPJ'); ?></td>
		<td><?php printf("%s.%s.%s/%s-%s", substr($titular['Titular']['cnpj'],0,2), substr($titular['Titular']['cnpj'],2,3), substr($titular['Titular']['cnpj'],5,3), substr($titular['Titular']['cnpj'],8,4), substr($titular['Titular']['cnpj'],-2)); ?></td>
	</tr>
	<tr>
		<td style="width:100px"><?php __('Contato'); ?></td>
		<td><?php echo $titular['Titular']['contatos']; ?></td>
	</tr>
</table>
</div>

<div class="related">
	<h2><?php __('Tecnologias');?></h2>
	<?php if (!empty($titular['Tecnologia'])):?>
	<h3><?php printf(__('Foram encontradas <strong>%d</strong> tecnologias relacionadas.', true),count($titular['Tecnologia'])) ?></h3>
	
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('#'); ?></th>
		<th><?php __('Titulo'); ?></th>
		<th><?php __('Núm Pedido'); ?></th>
		<th><?php __('Data'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($titular['Tecnologia'] as $tecnologia):
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
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'tecnologias', 'action' => 'view', $tecnologia['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'tecnologias', 'action' => 'edit', $tecnologia['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php else: ?>
	<h3><?php __('Não foram encontradas tecnologias relacionadas com este titular.') ?></h3>
<?php endif; ?>
</div>

<div class="related">
	<h2><?php __('Desenhos Industriais');?></h2>
	<?php if (!empty($titular['Desenho'])):?>
	<h3><?php printf(__('Foram encontradas <strong>%d</strong> desnhos industriais relacionados.', true),count($titular['Desenho'])) ?></h3>
	
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('#'); ?></th>
		<th><?php __('Titulo'); ?></th>
		<th><?php __('Núm Pedido'); ?></th>
		<th><?php __('Data'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($titular['Desenho'] as $desenho):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td class="id"><?php echo $j++; ?></td>
			<td class="titulo_tecnologia"><?php echo $desenho['titulo'];?></td>
			<td class="num_pedido"><?php echo $desenho['num_pedido'];?></td>
			<td class="data"><?php echo $time->format('d.m.Y', $desenho['data']); ?>&nbsp;</td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'desenhos', 'action' => 'view', $desenho['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'desenhos', 'action' => 'edit', $desenho['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php else: ?>
	<h3><?php __('Não foram encontradas desenhos industriais relacionados com este titular.') ?></h3>
<?php endif; ?>
</div>

<div class="related">
	<h2><?php __('Marcas');?></h2>
	<?php if (!empty($titular['Marca'])):?>
	<h3><?php printf(__('Foram encontradas <strong>%d</strong> marcas relacionadas.', true),count($titular['Marca'])) ?></h3>
	
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('#'); ?></th>
		<th><?php __('Titulo'); ?></th>
		<th><?php __('Núm Pedido'); ?></th>
		<th><?php __('Data'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($titular['Marca'] as $marca):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td class="id"><?php echo $j++; ?></td>
			<td class="titulo_tecnologia"><?php echo $marca['nome'];?></td>
			<td class="num_pedido"><?php echo $marca['processo'];?></td>
			<td class="data"><?php echo $time->format('d.m.Y', $marca['data']); ?>&nbsp;</td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'marcas', 'action' => 'view', $marca['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'marcas', 'action' => 'edit', $marca['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php else: ?>
	<h3><?php __('Não foram encontradas marcas relacionadas com este titular.') ?></h3>
<?php endif; ?>
</div>

<div class="related">
	<h2><?php __('Softwares');?></h2>
	<?php if (!empty($titular['Software'])):?>
	<h3><?php printf(__('Foram encontradas <strong>%d</strong> softwares relacionados.', true),count($titular['Desenho'])) ?></h3>
	
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('#'); ?></th>
		<th><?php __('Titulo'); ?></th>
		<th><?php __('Núm Pedido'); ?></th>
		<th><?php __('Data'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($titular['Software'] as $software):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td class="id"><?php echo $j++; ?></td>
			<td class="titulo_tecnologia"><?php echo $software['titulo'];?></td>
			<td class="num_pedido"><?php echo $software['num_pedido'];?></td>
			<td class="data"><?php echo $time->format('d.m.Y', $software['data']); ?>&nbsp;</td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'desenhos', 'action' => 'view', $software['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'desenhos', 'action' => 'edit', $software['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php else: ?>
	<h3><?php __('Não foram encontradas softwares relacionados com este titular.') ?></h3>
<?php endif; ?>
</div>