<div class="actions" align="middle">
	<ul>
		<li><?php echo $this->Html->link(__('Andamentos', true), array('controller' => 'andamentos', 'action' => 'index'), array('class'=>$this->name=='Andamentos'?'ativo':'')); ?></li>
		<li><?php echo $this->Html->link(__('Areas', true), array('controller' => 'areas', 'action' => 'index'), array('class'=>$this->name=='Areas'?'ativo':'')); ?> </li>
		<li><?php echo $this->Html->link(__('Despachos', true), array('controller' => 'despachos', 'action' => 'index'), array('class'=>$this->name=='Despachos'?'ativo':'')); ?> </li>
		<li><?php echo $this->Html->link(__('Documentos', true), array('controller' => 'documentos', 'action' => 'index'), array('class'=>$this->name=='Documentos'?'ativo':'')); ?> </li>
		<li><?php echo $this->Html->link(__('Escritórios', true), array('controller' => 'escritorios', 'action' => 'index'), array('class'=>$this->name=='Escritorios'?'ativo':'')); ?> </li>
		<li><?php echo $this->Html->link(__('Países', true), array('controller' => 'paises', 'action' => 'index'), array('class'=>$this->name=='Países'?'ativo':'')); ?></li>
		<li><?php echo $this->Html->link(__('Palavras-chave', true), array('controller' => 'palavraschave', 'action' => 'index'), array('class'=>$this->name=='Palavraschave'?'ativo':'')); ?></li>
		<li><?php echo $this->Html->link(__('Redatores', true), array('controller' => 'redatores', 'action' => 'index'), array('class'=>$this->name=='Redatores'?'ativo':'')); ?></li>
		<li><?php echo $this->Html->link(__('Status PI', true), array('controller' => 'status', 'action' => 'index'), array('class'=>$this->name=='Status'?'ativo':'')); ?></li>
		<li><?php echo $this->Html->link(__('Usuários', true), array('controller' => 'users', 'action' => 'index'), array('class'=>$this->name=='Users'?'ativo':'')); ?></li>
	</ul>
</div>