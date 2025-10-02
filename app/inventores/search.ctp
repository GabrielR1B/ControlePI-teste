<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Inventores', true), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('New Inventor', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Buscar Inventores', true), array('action' => 'search')); ?></li>
		<li><?php echo $this->Html->link(__('Listar inventores por núm. tecnologias', true), array('action' => 'listar')); ?></li>
	</ul>
</div>

<div class="inventores index">
	<h2><?php __('Inventores');?></h2>
	
		<?php echo
			$this->Form->create('Inventor', 
				array(
					'action' => 'search',
					//'inputDefaults' => array('label' => false, 'div' => false)
				)
			); 
		?>

		<fieldset>
		<?php
			echo $this->Form->input('nome', array('label' => 'Nome ou parte do nome', 'type' => 'text'));
			echo $this->Form->input('cpf', array('label' => 'CPF', 'type' => 'text'));
		?>
			<?php echo $this->Form->end(__('Submit', true));?>
		</fieldset>
	
	<?php if (!empty($inventores)): ?>
		<?php if (count($inventores)>1): ?>
			<h3><?php printf(__('Foram encontrados <strong>%d</strong> autores.', true),count($inventores)) ?></h3>
		<?php else: ?>
			<h3><?php printf(__('Foi encontrado <strong>%d</strong> autor.', true),count($inventores)) ?></h3>
		<?php endif; ?>

			<table class="simples" cellpadding="0" cellspacing="0">
			<tr>
					<th><?php __('#');?></th>
					<th><?php __('nome');?></th>
					<th class="actions"><?php __('Actions');?></th>
			</tr>

			<?php
			$i = 0;

			foreach ($inventores as $inventor):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td class="id"><?php echo $i; ?></td>
				<td>
					<p><?php echo $inventor['Inventor']['nome']; ?></p>
				</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View', true), array('action' => 'view', $inventor['Inventor']['id'])); ?>
					<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $inventor['Inventor']['id'])); ?>
					<?php echo $this->Html->link(__('Excluir', true), array('action' => 'delete', $inventor['Inventor']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $inventor['Inventor']['id'])); ?>
				</td>
			</tr>
			<?php endforeach; ?>
			
		</table>
	<?php elseif (isset($inventores)): ?>
		<h3>Sua busca não gerou resultados.</h3>
	<?php endif; ?>

</div>