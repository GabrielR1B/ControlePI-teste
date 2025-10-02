<div class="actions" align="middle">
	<ul>
		<li><?php echo $this->Html->link(__('Andamentos', true), array('controller' => 'andamentos', 'action' => 'index'), array('class'=>$this->name=='Andamentos'?'ativo':'')); ?></li>
		<li><?php echo $this->Html->link(__('Areas', true), array('controller' => 'areas', 'action' => 'index'), array('class'=>$this->name=='Areas'?'ativo':'')); ?> </li>
		<li><?php echo $this->Html->link(__('Países', true), array('controller' => 'paises', 'action' => 'index'), array('class'=>$this->name=='Países'?'ativo':'')); ?></li>
		<li><?php echo $this->Html->link(__('Palavras-chave', true), array('controller' => 'palavraschave', 'action' => 'index'), array('class'=>$this->name=='Palavraschave'?'ativo':'')); ?></li>
		<li><?php echo $this->Html->link(__('Status PI', true), array('controller' => 'status', 'action' => 'index'), array('class'=>$this->name=='Status'?'ativo':'')); ?></li>
		<li><?php echo $this->Html->link(__('Usuários', true), array('controller' => 'users', 'action' => 'index'), array('class'=>$this->name=='Users'?'ativo':'')); ?></li>
		</br></br></br>
		<div class="actions" align="left">
			<ul>
				<li><?php echo $this->Html->link(__('Listar Palavras-chave', true), array('action' => 'index')); ?></li>
				<li><?php echo $this->Html->link(__('Nova Palavra-chave', true), array('action' => 'add')); ?></li>
				<li><?php echo $this->Html->link(__('Buscar Palavra-Chave', true), array('action' => 'search')); ?></li>
				<li><?php echo $this->Html->link(__('Listar número de tecnologias por palavra-chave', true), array('action' => 'listar')); ?></li>
			</ul>
		</div>
	</ul>
</div>

<div class="palavraschave index">
	<h2><?php __('Palavras-chave');?></h2>
	
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
	
	<table class="simples" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php __('#');?></th>
			<th><?php echo $this->Paginator->sort('Palavra-chave');?></th>
			<th class="actions"><?php __('');?></th>
	</tr>
	<?php
	$i = 0;
	$j = 0;
	$item = $this->Paginator->counter(array('format' => '%start%'));
	
	foreach ($palavraschave as $palavrachave):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td class="id"><?php echo $item + $j++; ?></td>
		<td>
			<p><?php echo $palavrachave['Palavrachave']['palavra']; ?></p>
			<p style="color:#888;font-size:11px">Número de tecnologias: <?php echo count($palavrachave['Tecnologia']); ?></p>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $palavrachave['Palavrachave']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $palavrachave['Palavrachave']['id'])); ?>
			<?php echo $this->Html->link(__('Excluir', true), array('action' => 'delete', $palavrachave['Palavrachave']['id']), null, 'Tem certeza que deseja excluir esta palavra chave?', $palavrachave['Palavrachave']['id']); ?>
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