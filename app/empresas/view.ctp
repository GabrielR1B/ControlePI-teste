<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Empresas', true), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('Nova Empresa', true), array('action' => 'add')); ?></li>
	</ul>
</div>

<div class="empresas view">
<h2><?php  __('Empresa');?></h2>
	<table cellpadding = "0" cellspacing = "0">
		<?php $i = 0; $class = ' class="altrow"';?>
		<tr>
			<td style="width:180px"><?php __('Nome'); ?></td>
			<td><?php echo $empresa['Empresa']['nome']; ?></td>
		</tr>
		<tr>
			<td style="width:180px"><?php __('Área de Atuação'); ?></td>
			<td><?php echo $empresa['Empresa']['area_atuacao']; ?></td>
		</tr>
		<tr>
			<td style="width:180px"><?php __('Nome do Contato'); ?></td>
			<td><?php echo $empresa['Empresa']['nome_contato']; ?></td>
		</tr>
		<tr>
			<td style="width:180px"><?php __('Cargo'); ?></td>
			<td><?php echo $empresa['Empresa']['cargo']; ?></td>
		</tr>
		<tr>
			<td style="width:180px"><?php __('Telefone'); ?></td>
			<td><?php echo $empresa['Empresa']['telefone']; ?></td>
		</tr>
		<tr>
			<td style="width:180px"><?php __('E-mail'); ?></td>
			<td><?php echo $empresa['Empresa']['email']; ?></td>
		</tr>
	</table>
</div>

<div class="related">
	<h2><?php __('Tecnologias Ofertadas');?></h2>
	<br>
	<?php if (!empty($pis)):?>
	
	<table cellpadding = "0" cellspacing = "0">
	<colgroup>
       <col span="1" style="width: 3%;">
       <col span="1" style="width: 10%;">
       <col span="1" style="width: 10%;">
       <col span="1" style="width: 50%;">
       <col span="1" style="width: 10%;">
       <col span="1" style="width: 5%;">
    </colgroup>
	<tr>
		<th><?php __('#'); ?></th>
		<th><?php __('Natureza'); ?></th>
		<th><?php __('Núm Pedido'); ?></th>
		<th><?php __('Titulo'); ?></th>
		<th><?php __('Pasta'); ?></th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($pis as $pi):
			if($pi['tipo_relacao_id'] == '1'){
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
		?>
		<tr<?php echo $class;?>>
			<td class="id"><?php echo $j++; ?></td>
			<td class="natureza"><?php echo $pi['natureza'];?></td>
			<td class="num_pedido"><?php echo $pi['num_pedido'];?></td>
			<td class="titulo"><?php echo $this->Html->link($pi['titulo'], array('controller'=>$pi['controller'], 'action' => 'view', $pi['pi_id']), array('class' => 'titulo')); ?></td>
			<td class="pasta"><?php echo $pi['pasta'];?></td>
		</tr>
	<?php } endforeach; ?>
	</table>
<?php else: ?>
	<h3><?php __('Não foram encontradas tecnologias ofertadas para esta empresa.') ?></h3>
<?php endif; ?>
</div>
<br>
<br>
<div class="related">
	<h2><?php __('Tecnologias com Autorização de Teste');?></h2>
	<br>
	<?php if (!empty($pis)):?>
	
	<table cellpadding = "0" cellspacing = "0">
	<colgroup>
       <col span="1" style="width: 3%;">
       <col span="1" style="width: 10%;">
       <col span="1" style="width: 10%;">
       <col span="1" style="width: 50%;">
       <col span="1" style="width: 10%;">
       <col span="1" style="width: 5%;">
    </colgroup>
	<tr>
		<th><?php __('#'); ?></th>
		<th><?php __('Natureza'); ?></th>
		<th><?php __('Núm Pedido'); ?></th>
		<th><?php __('Titulo'); ?></th>
		<th><?php __('Pasta'); ?></th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($pis as $pi):
			if($pi['tipo_relacao_id'] == '3'){
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
		?>
		<tr<?php echo $class;?>>
			<td class="id"><?php echo $j++; ?></td>
			<td class="natureza"><?php echo $pi['natureza'];?></td>
			<td class="num_pedido"><?php echo $pi['num_pedido'];?></td>
			<td class="titulo"><?php echo $this->Html->link($pi['titulo'], array('controller'=>$pi['controller'], 'action' => 'view', $pi['pi_id']), array('class' => 'titulo')); ?></td>
			<td class="pasta"><?php echo $pi['pasta'];?></td>
		</tr>
	<?php } endforeach; ?>
	</table>
<?php else: ?>
	<h3><?php __('Não foram encontradas tecnologias licenciadas para esta empresa.') ?></h3>
<?php endif; ?>
</div>
<br>
<br>
<div class="related">
	<h2><?php __('Tecnologias Licenciadas');?></h2>
	<br>
	<?php if (!empty($pis)):?>
	
	<table cellpadding = "0" cellspacing = "0">
	<colgroup>
       <col span="1" style="width: 3%;">
       <col span="1" style="width: 10%;">
       <col span="1" style="width: 10%;">
       <col span="1" style="width: 50%;">
       <col span="1" style="width: 10%;">
       <col span="1" style="width: 5%;">
    </colgroup>
	<tr>
		<th><?php __('#'); ?></th>
		<th><?php __('Natureza'); ?></th>
		<th><?php __('Núm Pedido'); ?></th>
		<th><?php __('Titulo'); ?></th>
		<th><?php __('Pasta'); ?></th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($pis as $pi):
			if($pi['tipo_relacao_id'] == '2'){
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
		?>
		<tr<?php echo $class;?>>
			<td class="id"><?php echo $j++; ?></td>
			<td class="natureza"><?php echo $pi['natureza'];?></td>
			<td class="num_pedido"><?php echo $pi['num_pedido'];?></td>
			<td class="titulo"><?php echo $this->Html->link($pi['titulo'], array('controller'=>$pi['controller'], 'action' => 'view', $pi['pi_id']), array('class' => 'titulo')); ?></td>
			<td class="pasta"><?php echo $pi['pasta'];?></td>
		</tr>
	<?php } endforeach; ?>
	</table>
<?php else: ?>
	<h3><?php __('Não foram encontradas tecnologias licenciadas para esta empresa.') ?></h3>
<?php endif; ?>
</div>