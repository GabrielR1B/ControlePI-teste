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
		<td style="width:100px"><?php __('Nome'); ?></td>
		<td><?php echo $inventor['Inventor']['nome']; ?></td>
	</tr>
	<tr class="altrow">
		<td><?php __('Contatos'); ?></td>
		<td><?php echo nl2br($inventor['Inventor']['contatos']); ?></td>
	</tr>
	<tr>
		<td style="width:100px"><?php __('Categoria'); ?></td>
		<td><?php echo $inventor['Categoria']['nome']; ?></td>
	</tr>
</table>
</div>

<div class="related">
	<h2><?php __('Tecnologias Relacionadas');?></h2>
	<?php if (!empty($inventor['Tecnologia'])):?>
	<h3><?php printf(__('Foram encontradas <strong>%d</strong> tecnologias relacionadas.', true),count($inventor['Tecnologia'])) ?></h3>
	
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('#'); ?></th>
		<th><?php __('Titulo'); ?></th>
		<th><?php __('Núm Pedido'); ?></th>
		<th><?php __('Data'); ?></th>
		<th><?php __('Pasta'); ?></th>
		<th><?php __('Termo de Participação'); ?></th>
		<th><?php __('Declaração do Inventor'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
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
			<td class="num_pedido"><?php echo $tecnologia['num_pedido'];?></td>
			<td class="data"><?php echo $time->format('d.m.Y', $tecnologia['data']); ?>&nbsp;</td>
			<td class="num_pedido"><?php echo $tecnologia['pasta'];?></td>
			<td class="num_pedido"><?php if($tecnologia['termo_de_participacao']) {
				echo "<img src= '/controle-pi/img/check-icon.png', width = '15'>";
			}else{
				echo "<img src= '/controle-pi/img/not-check-icon.png', width = '15'>";
			} ?></td>
			<td class="num_pedido"><?php if($tecnologia['declaracao_do_inventor']) {
				echo "<img src= '/controle-pi/img/check-icon.png', width = '15'>";
			}else{
				echo "<img src= '/controle-pi/img/not-check-icon.png', width = '15'>";
			}?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'tecnologias', 'action' => 'view', $tecnologia['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'tecnologias', 'action' => 'edit', $tecnologia['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php else: ?>
	<h3><?php __('Não foram encontradas tecnologias relacionadas com este inventor.') ?></h3>
<?php endif; ?>
</div>
