<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Países', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Novo País', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Editar País', true), array('action' => 'edit', $pais['Pais']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Deletar País', true), array('action' => 'delete', $pais['Pais']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $pais['Pais']['id'])); ?> </li>
	</ul>
</div>

<div class="tecnologias index">
	<h2><?php __($pais['Pais']['nome']);?></h2>
	
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
	
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php __('#');?></th>
			<th><?php echo $this->Paginator->sort('titulo');?></th>
			<th>Nº do pedido</th>
			<th>Pasta</th>
			<th><?php echo $this->Paginator->sort('data');?></th>
			<th><?php //echo $this->Paginator->sort('area_id');?></th>
			<!-- <th><?php echo $this->Paginator->sort('situacao_id');?></th>
			<th><?php echo $this->Paginator->sort('status_id');?></th> -->
			<?php
				if($session->read('Auth.User.group_id')==1){
					echo "<th class='actions'>"; 
					__('Actions'); 
					echo "</th>";
				}
			?>

	</tr>
	<?php
	$i = 0;
	$j = 0;
	$item = $this->Paginator->counter(array('format' => '%start%'));
	foreach ($patentes as $patente):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>	
	<tr<?php echo $class;?>>
		<td class="id" ><?php echo $item + $j++; ?></td>
		
		<td class="titulo_tecnologia">
			
			<?php 
			echo $this->Html->link($patente['PatenteInternacional']['titulo'],
				array('controller' => 'patentes_internacionais','action' => 'view', $patente['PatenteInternacional']['id']),
				array('class' => 'titulo')
				);
			 ?>
			
			<?php if (!empty($tecnologia['Inventor'])): ?>
				<?php $count = count($tecnologia['Inventor']) ?>
				<?php $k=1 ?>
				<div class="inventores">
					<p>
					<?php foreach ($tecnologia['Inventor'] as $inventor):	?>
						<?php echo $this->Html->link($inventor['nome'], array('controller' => 'inventores', 'action' => 'view', $inventor['id'])); ?><?php echo ($k<$count?' / ':'');  ?>						
						<?php $k++ ?>
					<?php endforeach; ?>
					</p>
				</div>
			<?php endif; ?>
			
			<?php if (!empty($tecnologia['Palavrachave'])): ?>
				<?php $count = count($tecnologia['Palavrachave']) ?>
				<div class="palavraschave">
					<?php foreach ($tecnologia['Palavrachave'] as $palavrachave):	?>
						<?php echo $this->Html->link($palavrachave['palavra'], array('controller' => 'palavraschave', 'action' => 'view', $palavrachave['id'])); ?>			
					<?php endforeach; ?>
				</div>
			<?php endif; ?>			
		</td>
		
		<td class="num_pedido">
			<?php
				if(!$patente['PatenteInternacional']['pasta']) {
					$patente['PatenteInternacional']['pasta'] = '-';
				}
			?>
			<?php printf( '<p>%s</p><p style="color:#777;margin-top:5px"> </p>', $patente['PatenteInternacional']['num_pedido']) ?>&nbsp;
		</td>
		
		<td class="num_arquivos"><center><?php echo $patente['PatenteInternacional']['pasta']; ?></center></td>
		
		<td class="data"><?php echo $time->format('d.m.Y', $patente['PatenteInternacional']['data']); ?>&nbsp;</td>
		<td><?php /*echo $this->Html->link($patente['Area']['nome'], array('controller' => 'areas', 'action' => 'view', $patente['Area']['id']));*/ ?></td>
		<!-- 		
		<td><?php echo $this->Html->link($tecnologia['Status']['nome'], array('controller' => 'status', 'action' => 'view', $tecnologia['Status']['id'])); ?></td> -->
			
			<?php			
				if($session->read('Auth.User.group_id')==1){
					echo "<td class='actions'>";
			 		echo $this->Html->link(__('View', true), array('controller'=>'patentes_internacionais','action' => 'view', $patente['PatenteInternacional']['id'])); 
					echo $this->Html->link(__('Edit', true), array('controller'=>'patentes_internacionais','action' => 'edit', $patente['PatenteInternacional']['id'])); 
				 	echo $this->Html->link(__('Excluir', true), array('controller'=>'patentes_internacionais','action' => 'delete', $patente['PatenteInternacional']['id']), null, sprintf(__('Tem certeza que deseja excluir esta tecnologia?', true), $patente['PatenteInternacional']['id']));
					echo "</td>";
				}
			
			?>
	</tr>
<?php endforeach; ?>
	</table>
	
	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>

</div>