<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Novo Despacho', true), array('action' => 'add')); ?></li>
	</ul>
</div>
<div class="despachos index">
	<h2><?php __('Despachos');?></h2>
	
	<table class="simples" cellpadding="0" cellspacing="0">
	<tr>
			<th>Código</th>
			<th>Título</th>
			<th>Requer ação</th>
			<th>Prazo</th>
			<th>Ações</th>
	</tr>
	<?php
	$i = 0;
	$j = 0;
	
	foreach ($despachos as $despacho):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td class="data" style="text-align: left;"><?= $despacho['Despacho']['codigo']; ?></td>
		<td class="data" style="text-align: left;"><?= $despacho['Despacho']['titulo']; ?></td>
		<td class="data" style="text-align: left;"><?= $despacho['Despacho']['requer_acao'] == 1 ? 'Sim' : 'Não'; ?></td>
		<td class="data" style="text-align: left;"><?= $despacho['Despacho']['prazo'] !='' ? $despacho['Despacho']['prazo'].' dias' : ''; ?></td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $despacho['Despacho']['codigo'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>