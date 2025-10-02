<?php
//	print_r($inventor);
//	exit();
?>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Inventores', true), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('New Inventor', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Buscar Inventores', true), array('action' => 'search')); ?></li>
		<li><?php echo $this->Html->link(__('Edit Inventor', true), array('action' => 'edit', $inventor['Inventor']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Inventor', true), array('action' => 'delete', $inventor['Inventor']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $inventor['Inventor']['id'])); ?> </li>
	</ul>
</div>

<div class="inventores view">
<h2><?php  __('Inventor');?></h2>

<table cellpadding = "0" cellspacing = "0">
	<?php $i = 0; $class = ' class="altrow"';?>
	<tr>
		<td style="width:150px"><?php __('Nome'); ?></td>
		<td><?php echo $inventor['Inventor']['nome']; ?></td>
	</tr>
	<tr>
		<td style="width:150px"><?php __('CPF'); ?></td>
		<td><?php echo $inventor['Inventor']['cpf']; ?></td>
	</tr>
	<tr>
		<td style="width:150px"><?php __('Unidade'); ?></td>
		<td><?php echo $inventor['Inventor']['unidade']; ?></td>
	</tr>
	<tr>
		<td style="width:150px"><?php __('Departamento'); ?></td>
		<td><?php echo $inventor['Inventor']['departamento']; ?></td>
	</tr>
	<tr>
		<td style="width:150px"><?php __('Categoria'); ?></td>
		<td><?php echo $inventor['Inventor']['categoria']; ?></td>
	</tr>
	<tr>
		<td style="width:150px"><?php __('Vinculo à época'); ?></td>
		<td><?php echo $inventor['Inventor']['vinculo_a_epoca']; ?></td>
	</tr>
	<tr class="">
		<td><?php __('Telefone Profissional'); ?></td>
		<td><?php echo nl2br($inventor['Inventor']['telefone_profissional']); ?></td>
	</tr>
	<tr class="">
		<td><?php __('Telefone Residencial'); ?></td>
		<td><?php echo nl2br($inventor['Inventor']['telefone_residencial']); ?></td>
	</tr>
	<tr class="">
		<td><?php __('Celular'); ?></td>
		<td><?php echo nl2br($inventor['Inventor']['celular']); ?></td>
	</tr>
	<tr class="">
		<td><?php __('E-mail Institucional'); ?></td>
		<td><?php echo nl2br($inventor['Inventor']['email_institucional']); ?></td>
	</tr>
	<tr class="">
		<td><?php __('E-mail Alternativo'); ?></td>
		<td><?php echo nl2br($inventor['Inventor']['email_alternativo']); ?></td>
	</tr>
	<tr class="">
		<td><?php __('Contatos'); ?></td>
		<td><?php echo nl2br($inventor['Inventor']['contatos']); ?></td>
	</tr>
	<tr class="">
		<td><?php __('Observações'); ?></td>
		<td><?php echo nl2br($inventor['Inventor']['observacoes']); ?></td>
	</tr>
</table>
</div>

<div class="related">
	<h2><?php __('Tecnologias');?></h2>
	<?php if (!empty($inventor['Tecnologia'])):?>
	
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('#'); ?></th>
		<th><?php __('Titulo'); ?></th>
		<th><?php __('Pasta'); ?></th>
		<th><?php __('Núm Pedido'); ?></th>
		<th><?php __('Data'); ?></th>
		<th class="actions"><?php __('');?></th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($inventor['Tecnologia'] as $tecnologia):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td class="id"><?php echo $j++; ?></td>
			<td class="titulo_tecnologia"><?php echo $tecnologia['titulo'];?></td>
			<td class="pasta"><?php echo $tecnologia['pasta'];?></td>
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
	<h3><?php __('Não foram encontradas tecnologias deste inventor.') ?></h3>
<?php endif; ?>
</div>

<div class="related">
	<h2><?php __('Desenhos');?></h2>
	<?php if (!empty($inventor['Desenho'])):?>
	
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('#'); ?></th>
		<th><?php __('Titulo'); ?></th>
		<th><?php __('Pasta'); ?></th>
		<th><?php __('Núm Pedido'); ?></th>
		<th><?php __('Data'); ?></th>
		<th><?php __('Status'); ?></th>
		<th class="actions"><?php __('');?></th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($inventor['Desenho'] as $desenho):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td class="id"><?php echo $j++; ?></td>
			<td class="titulo_tecnologia"><?php echo $desenho['titulo'];?></td>
			<td class="num_pedido"><?php echo $desenho['pasta'];?></td>
			<td class="num_pedido"><?php echo $desenho['num_pedido'];?></td>
			<td class="data"><?php echo $time->format('d.m.Y', $desenho['data']); ?>&nbsp;</td>
			<td class="titulo_a_epoca"><?php echo $desenho['Status']['nome']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'softwares', 'action' => 'view', $desenho['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'softwares', 'action' => 'edit', $desenho['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php else: ?>
	<h3><?php __('Não foram encontrados desenho industriais relacionados com este inventor.') ?></h3>
<?php endif; ?>
</div>

<div class="related">
	<h2><?php __('Softwares');?></h2>
	<?php if (!empty($inventor['Software'])):?>
	
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('#'); ?></th>
		<th><?php __('Titulo'); ?></th>
		<th><?php __('Pasta'); ?></th>
		<th><?php __('Núm Pedido'); ?></th>
		<th><?php __('Data'); ?></th>
		<th><?php __('Status'); ?></th>
		<th class="actions"><?php __('');?></th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($inventor['Software'] as $software):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td class="id"><?php echo $j++; ?></td>
			<td class="titulo_tecnologia"><?php echo $software['titulo'];?></td>
			<td class="num_pedido"><?php echo $software['pasta'];?></td>
			<td class="num_pedido"><?php echo $software['num_pedido'];?></td>
			<td class="data"><?php echo $time->format('d.m.Y', $software['data']); ?>&nbsp;</td>
			<td class="titulo_a_epoca"><?php echo $software['Status']['nome']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'softwares', 'action' => 'view', $software['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'softwares', 'action' => 'edit', $software['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php else: ?>
	<h3><?php __('Não foram encontrados softwares relacionados com este inventor.') ?></h3>
<?php endif; ?>
</div>

<div class="related">
	<h2><?php __('Knowhow Relacionados');?></h2>
	<?php if (!empty($inventor['Knowhow'])):?>
	
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('#'); ?></th>
		<th><?php __('Titulo'); ?></th>
		<th><?php __('Pasta'); ?></th>
		<th><?php __('Data'); ?></th>
		<th class="actions"><?php __('');?></th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($inventor['Knowhow'] as $knowhow):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td class="id"><?php echo $j++; ?></td>
			<td class="titulo_tecnologia"><?php echo $knowhow['titulo'];?></td>
			<td class="num_pedido"><?php echo $knowhow['pasta'];?></td>
			<td class="data"><?php echo $time->format('d.m.Y', $knowhow['data']); ?>&nbsp;</td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'knowhows', 'action' => 'view', $knowhow['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'knowhows', 'action' => 'edit', $knowhow['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php else: ?>
	<h3><?php __('Não foram encontrados knowhow relacionados com este inventor.') ?></h3>
<?php endif; ?>
</div>