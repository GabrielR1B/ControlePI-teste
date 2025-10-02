<div class="actions" align="middle">
	<ul>
		<li><?php echo $this->Html->link(__('Andamentos', true), array('controller' => 'andamentos', 'action' => 'index'), array('class'=>$this->name=='Andamentos'?'ativo':'')); ?></li>
		<li><?php echo $this->Html->link(__('Areas', true), array('controller' => 'areas', 'action' => 'index'), array('class'=>$this->name=='Areas'?'ativo':'')); ?> </li>
		<li><?php echo $this->Html->link(__('Países', true), array('controller' => 'paises', 'action' => 'index'), array('class'=>$this->name=='Paises'?'ativo':'')); ?></li>
		<li><?php echo $this->Html->link(__('Palavras-chave', true), array('controller' => 'palavraschave', 'action' => 'index'), array('class'=>$this->name=='Palavraschave'?'ativo':'')); ?></li>
		<li><?php echo $this->Html->link(__('Status PI', true), array('controller' => 'status', 'action' => 'index'), array('class'=>$this->name=='Status'?'ativo':'')); ?></li>
		<li><?php echo $this->Html->link(__('Usuários', true), array('controller' => 'users', 'action' => 'index'), array('class'=>$this->name=='Users'?'ativo':'')); ?></li>
		<div class="actions" align="left">
			<ul>
				<li><?php echo $this->Html->link(__('Listar Redatores', true), array('action' => 'index')); ?> </li>
				<li><?php echo $this->Html->link(__('Adicionar Redator', true), array('action' => 'add')); ?> </li>
			</ul>
		</div>
	</ul>
</div>

<div class="areas index">
	<h2><?php __('Redatores');?></h2>
	
	<table class="simples" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('nome');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	$j = 0;
	$item = $this->Paginator->counter(array('format' => '%start%'));
	
	foreach ($redatores as $redator):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td class="id"><?php echo $item + $j++; ?></td>
		<td><?php echo $redator['Redator']['nome']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $redator['Redator']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $redator['Redator']['id'])); ?>
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
	  	<?php echo $this->Paginator->numbers();?>
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>