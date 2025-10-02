<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Redatores', true), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Novo Redator', true), array('action' => 'add')); ?></li>
	</ul>
</div>

<div class="redator index">
	<h2><?php echo $redator['Redator']['nome']?></h2>
	<table class="simples" cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo "#";    ?></th>
			<th><?php echo "Patentes";   ?></th>
			<th><?php echo "Pasta";   ?></th>
			<th class="actions"><?php __('Actions');?></th>
		</tr>
		<?php
		$i = 0;
		$j = 0;
		$item =	1;
		foreach ($redator['Tecnologia'] as $tecnologia):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td class="id"><?php echo $item + $j++; ?></td>
				<td><?php echo $tecnologia['titulo']; ?></td>
				<td><?php echo $tecnologia['pasta']; ?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View', true), array('controller'=>'tecnologias', 'action' => 'view', $tecnologia['id'])); ?>
					<?php echo $this->Html->link(__('Edit', true), array('controller'=>'tecnologias', 'action' => 'edit', $tecnologia['id'])); ?>
				</td>
			</tr>
		<?php 
		endforeach; 
		?>
	</table>
	<table class="simples" cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo "#";    ?></th>
			<th><?php echo "Desenhos Industriais";   ?></th>
			<th><?php echo "Pasta";   ?></th>
			<th class="actions"><?php __('Actions');?></th>
		</tr>
		<?php
		$i = 0;
		$j = 0;
		$item =	1;
		foreach ($redator['Desenho'] as $desenho):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td class="id"><?php echo $item + $j++; ?></td>
				<td><?php echo $desenho['titulo']; ?>&nbsp;</td>
				<td><?php echo $desenho['pasta']; ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View', true), array('controller'=>'tecnologias', 'action' => 'view', $tecnologia['id'])); ?>
					<?php echo $this->Html->link(__('Edit', true), array('controller'=>'tecnologias', 'action' => 'edit', $tecnologia['id'])); ?>
				</td>
			</tr>
		<?php 
		endforeach; 
		?>
	</table>
</div>