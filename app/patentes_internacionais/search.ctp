<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Patentes', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nova Patente', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Buscar Patentes', true), array('action' => 'search')); ?></li>
	</ul>
</div>

<div class="patentes index">
	<h2><?php __('Buscar Patentes');?></h2>
	
		<?php 
			echo $this->Form->create('PatenteInternacional',	array('url'=>'/patentes_internacionais/search')); 
		?>

		<fieldset>
		<?php
			echo $this->Form->input('titulo', array('label' => 'Título ou parte do título', 'type' => 'text'));
			echo $this->Form->input('num_pedido', array('label' => 'Número do pedido', 'type' => 'text'));
			echo $this->Form->input('num_publicacao', array('label' => 'Número de publicação', 'type' => 'text'));
			echo $this->Form->input('pasta', array('label' => 'Pasta', 'type' => 'text'));
			echo $this->Form->input('pasta_juridico', array('label' => 'Pasta Juridico', 'type' => 'text'));
			echo $this->Form->input('num_processo_sei', array('label' => 'Número do Processo SEI', 'type' => 'text'));
			echo $this->Form->input('natureza_id', array('label' => 'Natureza', 'empty' => 'Todos'));
			echo $this->Form->input('pais_id', array('empty' => __('Todos', true), 'label'=>'País'));
			echo $this->Form->input('inventor_id', array('empty' => __('Todos', true) ));
			echo $this->Form->input('titular_id', array('empty' => __('Todos', true) ));
			echo $this->Form->input('unidade_id', array('empty' => __('Todos', true) ));
			echo $this->Form->input('departamento_id', array('empty' => __('Todos', true) ));
			echo $this->Form->input('status_id', array('empty' => __('Todos', true) ));
			echo $this->Form->input('desde_id', array('type' => 'select','empty' => __('Todos', true), 'label' => 'De' ));
			echo $this->Form->input('ate_id', array('type' => 'select','empty' => __('Todos', true), 'label' => 'Até' ));
			// echo $this->Form->year('ano', 1920, date('Y'), 1950);
		?>
			<?php echo $this->Form->end(__('Submit', true));?>
		</fieldset>
	
	<?php if (!empty($patentes)){ ?>
		<?php if (count($patentes)>1): ?>
			<h3><?php printf(__('Foram encontradas <strong>%d</strong> tecnologias com os critérios de busca escolhidos.', true),count($patentes)) ?></h3>
		<?php else: ?>
			<h3><?php printf(__('Foi encontrada <strong>%d</strong> tecnologia com os critérios de busca escolhidos.', true),count($patentes)) ?></h3>
		<?php endif; ?>
		<table cellpadding="0" cellspacing="0">
			<tr>
					<th><?php __('#');?></th>
					<th><?php echo __('Título');?></th>
					<th><?php echo __('Pasta');?></th>
					<th><?php echo __('Número do Pedido');?></th>
					<th><?php echo __('Data');?></th>
					<th class="actions"><?php __('Actions');?></th>
			</tr>
		<?php
		$i = 0;
		foreach ($patentes as $patente):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		
		<tr<?php echo $class;?>>
			<td class="num"><?php echo $i ?>&nbsp;</td>

			<td class="titulo_tecnologia">
				<?php echo $patente['PatenteInternacional']['titulo']; ?>
			</td>
			<td>
				<?php echo $patente['PatenteInternacional']['pasta']; ?>
			</td>
			<td class="num_pedido">
				<?php
					if(!$patente['PatenteInternacional']['pasta']) {
						$patente['PatenteInternacional']['pasta'] = '-';
					}
				?>
				<?php 
					if($patente['PatenteInternacional']['natureza_id']!=1){
						echo $patente['PatenteInternacional']['num_pedido']."<br><br>";
						echo "<img src= '/controle-pi/img/flags/".$patente['Pais']['arquivo']."', width = '16'>"." ";
						echo $patente['Pais']['nome'];
					}else{
						echo $patente['PatenteInternacional']['num_pedido']."<br><br>";
						echo "<img src= '/controle-pi/img/flags/"."wipo.gif"."', width = '16'>"." ";
						echo "PCT";
					} 
				?>&nbsp;
			</td>
			<td class="data"><?php echo $time->format('d.m.Y', $patente['PatenteInternacional']['data']); ?>&nbsp;</td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('action' => 'view', $patente['PatenteInternacional']['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $patente['PatenteInternacional']['id'])); ?>
				<?php echo $this->Html->link(__('Excluir', true), array('action' => 'delete', $patente['PatenteInternacional']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $patente['PatenteInternacional']['id'])); ?>
			</td>
		</tr>
		<?php endforeach; ?>
		</table>
	<?php }elseif (isset($patentes)){ ?>
		<h3>Sua busca não gerou resultados.</h3>
	<?php } ?>

</div>
