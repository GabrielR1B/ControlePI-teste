<div class="actions" align="middle">
	<ul>
		<li><?php echo $this->Html->link(__('Andamentos', true), array('controller' => 'andamentos', 'action' => 'index'), array('class'=>$this->name=='Andamentos'?'ativo':'')); ?></li>
		<li><?php echo $this->Html->link(__('Areas', true), array('controller' => 'areas', 'action' => 'index'), array('class'=>$this->name=='Areas'?'ativo':'')); ?> </li>
		<li><?php echo $this->Html->link(__('Países', true), array('controller' => 'paises', 'action' => 'index'), array('class'=>$this->name=='Países'?'ativo':'')); ?></li>
		<li><?php echo $this->Html->link(__('Palavras-chave', true), array('controller' => 'palavraschave', 'action' => 'index'), array('class'=>$this->name=='Palavraschave'?'ativo':'')); ?></li>
		<li><?php echo $this->Html->link(__('Status PI', true), array('controller' => 'status', 'action' => 'index'), array('class'=>$this->name=='Status'?'ativo':'')); ?></li>
		<li><?php echo $this->Html->link(__('Usuários', true), array('controller' => 'users', 'action' => 'index'), array('class'=>$this->name=='Users'?'ativo':'')); ?></li>
		<div class="actions" align="left">
			<ul>
				<li><?php echo $this->Html->link(__('Nova Área', true), array('action' => 'add')); ?></li>
			</ul>
		</div>
	</ul>
</div>

<div class="areas index">
	<h2><?php __('Areas');?></h2>
	
	<table class="simples" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('nome');?></th>
			<th><?php echo $this->Paginator->sort('Nome em Inglês' ,'name');?></th>
			<th class="actions"><?php __('');?></th>
	</tr>
	<?php
	$i = 0;
	$j = 0;
	$item = $this->Paginator->counter(array('format' => '%start%'));
	
	foreach ($areas as $area):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td class="id"><?php echo $item + $j++; ?></td>
		<td><?php echo $area['Area']['nome']; ?>&nbsp;</td>
		<td><?php echo $area['Area']['name']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $area['Area']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $area['Area']['id'])); ?>
			<?php echo $this->Html->link(__('Excluir', true), array('action' => 'delete', $area['Area']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $area['Area']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
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
</div>