<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(('Listar Softwares'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Novo Software', true), array('action' => 'add')); ?></li>
	</ul>
</div>

<div class="tecnologias index">
	<h2><?php __('Buscar Software');?></h2>
	
		<?php echo
			$this->Form->create('Software', 
				array(
					'action' => 'search',
					//'inputDefaults' => array('label' => false, 'div' => false)
				)
			); 
		?>

		<fieldset>
		<?php
			echo $this->Form->input('titulo', array('label' => 'Título ou parte do título', 'type' => 'text'));
			echo $this->Form->input('num_pedido', array('label' => 'Número do pedido', 'type' => 'text'));
			echo $this->Form->input('pasta', array('label' => 'Pasta', 'type' => 'text'));
			echo $this->Form->input('pasta_juridico', array('label' => 'Pasta Jurídico', 'type' => 'text'));
			echo $this->Form->input('num_processo_sei', array('label' => 'Número do Processo SEI', 'type' => 'text'));
			echo $this->Form->input('unidade_id', array('empty' => __('Todas', true) ));
			echo $this->Form->input('status_id', array('empty' => __('Todos', true) ));
			echo $this->Form->input('Inventor', array('type' => 'select','empty' => __('Todos', true) ));
			echo $this->Form->input('desde', array('type' => 'select','empty' => __('Todos', true), 'label' => 'De' ));
			echo $this->Form->input('ate', array('type' => 'select','empty' => __('Todos', true), 'label' => 'Até' ));
		?>
			<?php echo $this->Form->end(__('Submit', true));?>
		</fieldset>

		<?php if (!empty($softwares)): ?>
		<?php if (count($softwares)>1): ?>
			<h3><?php printf(__('Foram encontrados <strong>%d</strong> softwares com os critérios de busca escolhidos.', true),count($softwares)) ?></h3>
		<?php else: ?>
			<h3><?php printf(__('Foi encontrado <strong>%d</strong> software com os critérios de busca escolhidos.', true),count($softwares)) ?></h3>
		<?php endif; ?>

		<table cellpadding="0" cellspacing="0">
			<tr>
					<th><?php __('#');?></th>
					<th><?php echo __('Título');?></th>
					<th><?php echo __('Núm Pedido');?></th>
					<th><?php echo __('Data');?></th>
					<th class="actions"><?php __('');?></th>
			</tr>

			<?php
			$i = 0;
			foreach ($softwares as $software):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
		
			<tr<?php echo $class;?>>
				<td class="num"><?php echo $i ?>&nbsp;</td>

				<td class="titulo_tecnologia">
					<?php echo $software['Software']['titulo']; ?>
					<?php if (!empty($software['Inventor'])): ?>
						<?php $count = count($software['Inventor']) ?>
						<?php $k=1 ?>
						<div class="inventores">
							<p>
							<?php foreach ($software['Inventor'] as $inventor):	?>
								<?php echo $this->Html->link($inventor['nome'], array('controller' => 'inventores', 'action' => 'view', $inventor['id'])); ?><?php echo ($k<$count?' / ':'');  ?>						
								<?php $k++ ?>
							<?php endforeach; ?>
							</p>
						</div>
					<?php endif; ?>
				</td>

				<td class="num_pedido">
				<?php
					if(!$software['Software']['pasta']) {
						$software['Software']['pasta'] = '-';
					}
				?>
				<?php printf( '<p>%s</p><p style="color:#777;margin-top:5px"> pasta: %s</p>', $software['Software']['num_pedido'], $software['Software']['pasta']) ?>&nbsp;
				</td>

				<td class="data"><?php echo $time->format('d.m.Y', $software['Software']['data']); ?>&nbsp;</td>

				<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('action' => 'view', $software['Software']['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $software['Software']['id'])); ?>
				<?php echo $this->Html->link(__('Excluir', true), array('action' => 'delete', $software['Software']['id']), null, sprintf(('Você tem certeza de que deseja excluir o software "%s"?'), $software['Software']['titulo'])); ?>
				</td>
			</tr>
			<?php endforeach; ?>
			</table>
		<?php elseif (isset($softwares)): ?>
			<h3>Sua busca não gerou resultados.</h3>
		<?php endif; ?>

	</div>