<div class="areas index">
	<h2><?php __('RPIs');?></h2>
	
	<table class="simples" cellpadding="0" cellspacing="0">
	<tr>
			<th>Número</th>
			<th>Data</th>
			<th>Total de Publicações</th>
			<th>Ações</th>
	</tr>
	<?php
	$i = 0;
	$j = 0;
	
	foreach ($rpis as $rpi):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td>
			<?php 
				echo $this->Html->link($rpi['Rpi']['numero'],	array('action' => 'view', $rpi['Rpi']['numero']),	array('class' => 'titulo'));
			 ?>
		</td>
		<td class="data" style="text-align: left;"><?php echo $time->format('d.m.Y', $rpi['Rpi']['data_publicacao']); ?></td>
		<td class="data" style="text-align: left;"><?php echo count($rpi['Publicacao']); ?></td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $rpi['Rpi']['numero'])); ?>
			<?php echo $this->Html->link(__('Documentos', true), array('action' => 'documentos', $rpi['Rpi']['numero'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>