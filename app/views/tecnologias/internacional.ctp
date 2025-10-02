<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Tecnologias', true), array('action' => 'internacional')); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Países', true), array('controller'=>'paises','action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('PCT', true), array('controller'=>'tecnologias','action' => 'pct')); ?> </li>
		<li><?php echo $this->Html->link(__('Buscar Tecnologias', true), array('action' => 'search')); ?></li>
		<?php
			if($session->read('Auth.User.group_id')==1){
		?>	
			<li><?php echo $this->Html->link(__('Nova Tecnologia', true), array('action' => 'add')); ?> </li>
		<?php
			}
		?>	
	</ul>
</div>

<div class="tecnologias index">
	<h2><?php __('Tecnologias');?></h2>
	
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
			<th>País</th>
			<th>Pasta</th>
			<th><?php echo $this->Paginator->sort('data');?></th>
			<th><?php echo $this->Paginator->sort('area_id');?></th>
			<!-- <th><?php echo $this->Paginator->sort('situacao_id');?></th>-->
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
	foreach ($tecnologias as $tecnologia):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>	
	<tr<?php echo $class;?>>
		<td class="id"><?php echo $item + $j++; ?></td>
		
		<td class="titulo_tecnologia">
			
			<?php 
			echo $this->Html->link(
				$tecnologia['Tecnologia']['titulo'],
				array('action' => 'view', $tecnologia['Tecnologia']['id']),
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
				if(!$tecnologia['Tecnologia']['pasta']) {
					$tecnologia['Tecnologia']['pasta'] = '-';
				}
			?>
			<?php printf( '<p>%s</p><p style="color:#777;margin-top:5px"> </p>', $tecnologia['Tecnologia']['num_pedido']) ?>&nbsp;
		</td>
		
		<td class="num_arquivos"><center><?php echo "<a href='../paises/view/".$tecnologia['Pais']['id']."'> <img src='/ctit/img/flags/".$tecnologia['Pais']['arquivo']."' title = '".$tecnologia['Pais']['nome']."', width = '15'></a>"; ?></center></td>

		<td class="num_arquivos"><center><?php echo $tecnologia['Tecnologia']['pasta']; ?></center></td>
		<?php
			$prazo = strtotime($tecnologia['Tecnologia']['data']." +1  year");
			
			$classe = "";
			if ($prazo < time()){
				$clase = '"atrasado"';
			}
		?>

		<td class= <?php echo $classe; ?> >
						<?php 
							echo $time->format('d.m.Y', $prazo); 
						?>&nbsp;</td>
		<td><?php echo $this->Html->link($tecnologia['Area']['nome'], array('controller' => 'areas', 'action' => 'view', $tecnologia['Area']['id'])); ?></td>
		<!-- <td><?php echo $this->Html->link($tecnologia['Situacao']['nome'], array('controller' => 'situacoes', 'action' => 'view', $tecnologia['Situacao']['id'])); ?></td>
		
		<td><?php echo $this->Html->link($tecnologia['Status']['nome'], array('controller' => 'status', 'action' => 'view', $tecnologia['Status']['id'])); ?></td> -->
			
			<?php			
				if($session->read('Auth.User.group_id')==1){
					echo "<td class='actions'>";
			 		echo $this->Html->link(__('View', true), array('action' => 'view', $tecnologia['Tecnologia']['id'])); 
					echo $this->Html->link(__('Edit', true), array('action' => 'edit', $tecnologia['Tecnologia']['id'])); 
				 	echo $this->Html->link(__('Excluir', true), array('action' => 'delete', $tecnologia['Tecnologia']['id']), null, sprintf(__('Tem certeza que deseja excluir esta tecnologia?', true), $tecnologia['Tecnologia']['id']));
					echo "</td>";
				}
			
			?>
	</tr>
<?php endforeach; ?>
	</table>
	
</div>