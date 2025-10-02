<?php 
	//Teste para gerar pdf
	//include 'mpdf/mpdf.php';
	//$mpdf=new mPDF('', 'A4', 0, '', 2, 2, 2, 2, 2, 2);
	//$mpdf->WriteHTML($homepage);
	//$mpdf->Output('filename.pdf','D');
?>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Novo Software', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Buscar Software', true), array('action' => 'search')); ?></li>
	</ul>
</div>

<div class="softwares index">
	<h2><?php __('Softwares');?></h2>
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
			<th><?php echo $this->Paginator->sort('pasta');?></th>
			<th><?php echo $this->Paginator->sort('titulo');?></th>
			<th><?php echo $this->Paginator->sort('Número do pedido','num_pedido');?></th>
			<th><?php echo $this->Paginator->sort('status_id');?></th>
			<th><?php echo $this->Paginator->sort('data');?></th>
			
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
		<td><?php echo $software['Software']['pasta']; ?>&nbsp;</td>
		<td><?php echo $software['Software']['titulo']; ?>&nbsp;</td>
		<td><?php echo $software['Software']['num_pedido']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($software['Status']['nome'], array('controller' => 'status', 'action' => 'view', $software['Status']['id'])); ?>
		</td>
		<td><?php echo $time->format('d.m.Y',$software['Software']['data']); ?>&nbsp;</td>
		
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $software['Software']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $software['Software']['id'])); ?>
			<?php echo $this->Html->link(__('Excluir', true), array('action' => 'delete', $software['Software']['id']), null, sprintf(('Você tem certeza de que deseja excluir o software "%s"?'), $software['Software']['titulo'])); ?>
		</td>
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