<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Inventores', true), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('New Inventor', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Buscar Inventores', true), array('action' => 'search')); ?></li>
		<li><?php echo $this->Html->link(__('Listar inventores por núm. tecnologias', true), array('action' => 'listar')); ?></li>
	</ul>
</div>

<div class="titulares index">
	<h2><?php __('Titulares');?></h2>
	
	<?php if (!empty($titulares)): ?>
		<?php if (count($titulares)>1): ?>
			<h3><?php printf(__('Foram encontrados <strong>%d</strong> titulares.', true),count($titulares)) ?></h3>
		<?php else: ?>
			<h3><?php printf(__('Foi encontrado <strong>%d</strong> titular.', true),count($titulares)) ?></h3>
		<?php endif; ?>

			<table class="simples" cellpadding="0" cellspacing="0">
			<tr>
					<th><?php __('#');?></th>
					<th><?php __('Nome');?></th>
					<th><?php __('Tecnologias');?></th>
					<th class="actions"><?php __('Actions');?></th>
			</tr>

			<?php
			$i = 0;

			foreach ($titulares as $titular):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td class="id"><?php echo $i; ?></td>
				<td>
					<p><?php echo $titular['i']['nome']; ?></p>
				</td>
				<td width="100"><center><?php echo $titular[0]['total']; ?></center></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View', true), array('action' => 'view', $titular['i']['id'])); ?>
					<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $titular['i']['id'])); ?>
				</td>
			</tr>
			<?php endforeach; ?>
			
		</table>
	<?php elseif (isset($titulares)): ?>
		<h3>Sua busca não gerou resultados.</h3>
	<?php endif; ?>

</div>