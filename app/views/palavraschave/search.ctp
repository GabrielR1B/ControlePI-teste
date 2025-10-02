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
	
		<?php echo
			$this->Form->create('Palavrachave', 
				array(
					'action' => 'search',
					//'inputDefaults' => array('label' => false, 'div' => false)
				)
			); 
		?>

		<fieldset>
		<?php
			echo $this->Form->input('palavra', array('label' => 'Nome ou parte do nome', 'type' => 'text'));
		?>
			<?php echo $this->Form->end(__('Submit', true));?>
		</fieldset>
	
	<?php if (!empty($palavraschave)): ?>
		<?php if (count($palavraschave)>1): ?>
			<h3><?php printf(__('Foram encontradas <strong>%d</strong> palavras-chave.', true),count($palavraschave)) ?></h3>
		<?php else: ?>
			<h3><?php printf(__('Foi encontrado <strong>%d</strong> palavra-chave.', true),count($palavraschave)) ?></h3>
		<?php endif; ?>

			<table class="simples" cellpadding="0" cellspacing="0">
			<tr>
					<th><?php __('#');?></th>
					<th><?php __('nome');?></th>
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
					<p><?php echo $palavrachave['Palavrachave']['palavra']; ?></p>
				</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View', true), array('action' => 'view', $palavrachave['Palavrachave']['id'])); ?>
					<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $palavrachave['Palavrachave']['id'])); ?>
					<?php echo $this->Html->link(__('Excluir', true), array('action' => 'delete', $palavrachave['Palavrachave']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $palavrachave['Palavrachave']['id'])); ?>
				</td>
			</tr>
			<?php endforeach; ?>
			
		</table>
	<?php elseif (isset($palavraschave)): ?>
		<h3>Sua busca não gerou resultados.</h3>
	<?php endif; ?>

</div>