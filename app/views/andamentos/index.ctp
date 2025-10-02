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
				<li><?php echo $this->Html->link(__('Novo Andamento', true), array('action' => 'add')); ?></li>
			</ul>
		</div>
	</ul>
</div>

<div class="andamentos index">
	<h2><?php __('Andamento');?></h2>
	
	<table class="simples" cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo 'Id';?></th>
			<th><?php echo 'Nome';?></th>
			<th class="actions"><?php __('');?></th>
	</tr>
	<?php
	$i = 0;
	$j = 0;
	

	foreach ($andamentos as $andamento):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = 'class="altrow"';
		}
	?>
	<tr <?php echo $class ?> >
	 	<td><?php echo $andamento['Andamento']['id']; ?></th>
	 	<td><?php echo $andamento['Andamento']['nome']; ?></th>
	 	
	 	<?php			
		if($session->read('Auth.User.group_id')==1){
			echo "<td class='actions'>";
		 	echo $this->Html->link(__('View', true), array('action' => 'view', $andamento['Andamento']['id'])); 
			echo $this->Html->link(__('Edit', true), array('action' => 'edit', $andamento['Andamento']['id'])); 
		 	echo $this->Html->link(__('Excluir', true), array('action' => 'delete', $andamento['Andamento']['id']), null, sprintf(__('Tem certeza que deseja excluir este andamento?', true), $andamento['Andamento']['id']));
			echo "</td>";
		}
	
		?>
	</tr>

<?php endforeach; ?>
	</table>
</div>