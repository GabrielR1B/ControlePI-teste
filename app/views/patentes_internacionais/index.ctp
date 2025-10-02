<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Patentes', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Buscar Patentes', true), array('action' => 'search')); ?></li>
		<li><?php echo $this->Html->link(__('Nova Patente Internacional', true), array('action' => 'add')); ?></li>
		<?php
			if($session->read('Auth.User.group_id')==1){

			}
		?>	
	</ul>
</div>

<div class="tecnologias index">
	<h2><?php __('Patentes Internacionais');?></h2>
	
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
			<th><?php echo $this->Paginator->sort('pasta'); ?></th>
			<th><?php echo $this->Paginator->sort('titulo'); ?></th>
			<th>Data de Depósito</th>
			<th>País</th>
			<th>Nº do pedido</th>
			<th>Natureza</th>
			<?php
				if($session->read('Auth.User.group_id')==1){
					echo "<th class='actions'>"; 
					__(''); 
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
		<td class="num_arquivos"><center><?php echo $patente['PatenteInternacional']['pasta']; ?></center></td>
		
		<td class="titulo_tecnologia">
			
			<?php 
			echo $this->Html->link(
				$patente['PatenteInternacional']['titulo'],
				array('action' => 'view', $patente['PatenteInternacional']['id']),
				array('class' => 'titulo')
				);
			 ?>
			
		</td>
		<td class="data_tecnologia" width="200">
			
			<?php
				echo $time->format('d.m.Y', $patente['PatenteInternacional']['data']);
			 ?>			
		</td>
		<td class="pais" width="300">
			<?php 
				if(isset($patente['Pais']['id'])){
					echo "<img src= '/controle-pi/img/flags/".$patente['Pais']['arquivo']."', width = '16'>";
					echo " ";
					echo $patente['Pais']['nome'];
				}else{
					echo "<img src='/controle-pi/img/flags/"."wipo.gif"."', width = '16'>";
					echo " ";
					echo "PCT";						
				}
			?>
		</td>
		<td class="num_pedido">
			<?php
				echo $this->Html->link($patente['PatenteInternacional']['num_pedido'], array('controller' => 'patentes_internacionais', 'action' => 'view', $patente['PatenteInternacional']['id']));
			?>
		</td>
		<td>
			<?php
				echo $patente['NaturezaPatenteInternacional']['nome'];
			?>
		</td>
		
			<?php			
				if($session->read('Auth.User.group_id')==1){
					echo "<td class='actions'>";
			 		echo $this->Html->link(__('View', true), array('action' => 'view', $patente['PatenteInternacional']['id'])); 
					echo $this->Html->link(__('Edit', true), array('action' => 'edit', $patente['PatenteInternacional']['id'])); 
				 	echo $this->Html->link(__('Excluir', true), array('action' => 'delete', $patente['PatenteInternacional']['id']), null, sprintf(__('Tem certeza que deseja excluir esta tecnologia?', true), $patente['PatenteInternacional']['id']));
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