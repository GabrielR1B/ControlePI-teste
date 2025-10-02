<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(('Listar Knowhow'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(('Novo Knowhow'), array('action' => 'add')); ?></li>
	</ul>
</div>

<div class="tecnologias index">
	<h2><?php __('Buscar Knowhow');?></h2>
	
		<?php echo
			$this->Form->create('Knowhow', 
				array(
					'action' => 'search',
					//'inputDefaults' => array('label' => false, 'div' => false)
				)
			); 
		?>

		<fieldset>
		<?php
			echo $this->Form->input('titulo', array('label' => 'Título ou parte do título', 'type' => 'text'));
			echo $this->Form->input('pasta', array('label' => 'Pasta', 'type' => 'text'));
			echo $this->Form->input('pasta_juridico', array('label' => 'Pasta Jurídico', 'type' => 'text'));
			echo $this->Form->input('num_processo_sei', array('label' => 'Número do Processo SEI', 'type' => 'text'));
			echo $this->Form->input('unidade_id', array('empty' => __('Todas', true) ));
			echo $this->Form->input('Inventor', array('type' => 'select','empty' => __('Todos', true) ));
			echo $this->Form->input('desde', array('type' => 'select','empty' => __('Todos', true), 'label' => 'De' ));
			echo $this->Form->input('ate', array('type' => 'select','empty' => __('Todos', true), 'label' => 'Até' ));
		?>
		<?php echo $this->Form->end(__('Submit', true));?>
		</fieldset>

		<?php if (!empty($knowhows)): ?>
			<?php if (count($knowhows)>1): ?>
				<h3><?php printf(__('Foram encontrados <strong>%d</strong> knowhow com os critérios de busca escolhidos.', true),count($knowhows)) ?></h3>
			<?php else: ?>
				<h3><?php printf(__('Foi encontrado <strong>%d</strong> knowhow com os critérios de busca escolhidos.', true),count($knowhows)) ?></h3>
			<?php endif; ?>

			<table cellpadding="0" cellspacing="0">
			<tr>
					<th><?php __('#');?></th>
					<th><?php echo __('Título');?></th>
					<th><?php echo __('Pasta');?></th>
					<th><?php echo __('Data');?></th>
					<th class="actions"><?php __('');?></th>
			</tr>
		<?php
		$i = 0;
		foreach ($knowhows as $knowhow):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>

		<tr<?php echo $class;?>>
			<td class="num"><?php echo $i ?>&nbsp;</td>

			<td class="titulo_tecnologia">
				<?php echo $knowhow['Knowhow']['titulo']; ?>
				<?php if (!empty($knowhow['Inventor'])): ?>
					<?php $count = count($knowhow['Inventor']) ?>
					<?php $k=1 ?>
					<div class="inventores">
						<p>
						<?php foreach ($knowhow['Inventor'] as $inventor):	?>
							<?php echo $this->Html->link($inventor['nome'], array('controller' => 'inventores', 'action' => 'view', $inventor['id'])); ?><?php echo ($k<$count?' / ':'');  ?>						
							<?php $k++ ?>
						<?php endforeach; ?>
						</p>
					</div>
				<?php endif; ?>
			</td>

			<td class="num_pedido">
				<?php echo $knowhow['Knowhow']['pasta']; ?>&nbsp;
			</td>
			<td class="data"><?php echo $time->format('d.m.Y', $knowhow['Knowhow']['data']); ?>&nbsp;</td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('action' => 'view', $knowhow['Knowhow']['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $knowhow['Knowhow']['id'])); ?>
				<?php echo $this->Html->link(__('Excluir', true), array('action' => 'delete', $knowhow['Knowhow']['id']), null, sprintf(('Você tem certeza de que deseja excluir o knowhow "%s"?'), $knowhow['Knowhow']['titulo'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
			</table>
	<?php elseif (isset($knowhows)): ?>
		<h3>Sua busca não gerou resultados.</h3>
	<?php endif; ?>

</div>