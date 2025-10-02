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
	
	<?php if (!empty($palavraschave)): ?>
		<?php if (count($palavraschave)>1): ?>
			<h3><?php printf(__('Foram encontrados <strong>%d</strong> palavras-chave.', true),count($palavraschave)) ?></h3>
		<?php else: ?>
			<h3><?php printf(__('Foi encontrado <strong>%d</strong> palavra-chave.', true),count($palavraschave)) ?></h3>
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

			foreach ($palavraschave as $palavrachave):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td class="id"><?php echo $i; ?></td>
				<td>
					<p><?php echo $palavrachave['p']['palavra']; ?></p>
				</td>
				<td width="100"><center><?php echo $palavrachave[0]['total']; ?></center></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View', true), array('action' => 'view', $palavrachave['p']['id'])); ?>
					<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $palavrachave['p']['id'])); ?>
				</td>
			</tr>
			<?php endforeach; ?>
			
		</table>
	<?php elseif (isset($inventores)): ?>
		<h3>Sua busca não gerou resultados.</h3>
	<?php endif; ?>

</div>