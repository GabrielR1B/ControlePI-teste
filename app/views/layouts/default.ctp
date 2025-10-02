<?php include('header.ctp'); ?>
</head>

<body>
	
	<?php //echo $this->element('sql_dump'); ?>
	<?php // echo "Page rendered in" . round((getMicroTime() - $_SERVER['REQUEST_TIME']) * 1000) . "ms." ?>
	
	
	<div id="ajax_flash" class="ui-state-highlight ui-corner-all"></div>
	<div id="container">
		<div id="header">
			<h1><?php echo $this->Html->link(__('CTIT | Controle de PI', true), '/'); ?></h1>
	
			<?php
				if($session->read('Auth.User.group_id')==true){
			?>		
			<div id="login">
			    Usuário logado: <strong><?php echo $session->read('Auth.User.first_name') . ' ' . $session->read('Auth.User.last_name'); ?></strong> - [ <?php echo $html->link('Logout', array('controller' => 'users', 'action' => 'logout')); ?> ]
			</div>
			
			<div class="actions" align="middle">
			<ul>
				
				<li><?php echo $this->Html->link(__('Patentes', true), array('controller' => 'tecnologias', 'action' => 'index'), array('class'=>$this->name=='Tecnologias'?'ativo':'')); ?></li>
				<li><?php echo $this->Html->link(__('Internacional', true), array('controller' => 'patentes_internacionais', 'action' => 'index'), array('class'=>$this->name=='PatentesInternacionais'?'ativo':'')); ?></li>
				<li><?php echo $this->Html->link(__('Desenhos Industriais', true), array('controller' => 'desenhos', 'action' => 'index'), array('class'=>$this->name=='Desenhos'?'ativo':'')); ?></li>
				<li><?php echo $this->Html->link(__('Marcas', true), array('controller' => 'marcas', 'action' => 'index'), array('class'=>$this->name=='Marcas'?'ativo':'')); ?></li>
				<li><?php echo $this->Html->link(__('Softwares', true), array('controller' => 'softwares', 'action' => 'index'), array('class'=>$this->name=='Softwares'?'ativo':'')); ?></li>
				<li><?php echo $this->Html->link(__('Knowhow', true), array('controller' => 'knowhows', 'action' => 'index'), array('class'=>$this->name=='Knowhows'?'ativo':'')); ?></li>
				<li><?php echo $this->Html->link(__('Inventors', true), array('controller' => 'inventores', 'action' => 'index'), array('class'=>$this->name=='Inventores'?'ativo':'')); ?> </li>
				<li><?php echo $this->Html->link(__('Titulares', true), array('controller' => 'titulares', 'action' => 'index'), array('class'=>$this->name=='Titulares'?'ativo':'')); ?> </li>
				<li><?php echo $this->Html->link(__('RPIs', true), array('controller' => 'rpis', 'action' => 'index'), array('class'=>$this->name=='RPIs'?'ativo':'')); ?> </li>
				<li><?php echo $this->Html->link(__('Publicações', true), array('controller' => 'publicacoes', 'action' => 'index'), array('class'=>$this->name=='Publicacoes'?'ativo':'')); ?> </li>
				<li><?php echo $this->Html->link(__('Empresas', true), array('controller' => 'empresas', 'action' => 'index'), array('class'=>$this->name=='Empresas'?'ativo':'')); ?> </li>
				<li><?php echo $this->Html->link(__('Contatos', true), array('controller' => 'contatos', 'action' => 'index'), array('class'=>$this->name=='Contatos'?'ativo':'')); ?> </li>
				<li><?php echo $this->Html->link(__('Gráficos', true), array('controller' => 'graficos', 'action' => 'index'), array('class'=>$this->name=='Graficos'?'ativo':'')); ?></li>
				<li><?php echo $this->Html->link(__('Administrar', true), array('controller' => 'opcoes', 'action' => 'index'), array('class'=>$this->name=='Opcoes'?'ativo':'')); ?> </li>
				<!--	
					<li><?php //echo $this->Html->link(__('Andamentos', true), array('controller' => 'andamentos', 'action' => 'index'), array('class'=>$this->name=='Andamentos'?'ativo':'')); ?></li>
					<li><?php //echo $this->Html->link(__('Palavras-chave', true), array('controller' => 'palavraschave', 'action' => 'index'), array('class'=>$this->name=='Palavraschave'?'ativo':'')); ?></li>
					<li><?php //echo $this->Html->link(__('Status', true), array('controller' => 'status', 'action' => 'index'), array('class'=>$this->name=='Status'?'ativo':'')); ?></li>
				-->

				<?php
					}
				?>

				<?php
					if($session->read('Auth.User.group_id')==1){
				?>				
				<?php
					}
				?>		
			</ul>
			</div>
			
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $content_for_layout; ?>

		</div>
		<div id="footer">
			<?php 
					echo $this->Html->link(
					$this->Html->image('ctit.png', array('alt'=> __('Coordenadoria de Transferência e Inovação Tecnológica', true), 'border' => '0')),
					'/',
					array('escape' => false)
				);
			?>
		</div>
	</div>
	<?php //echo $this->element('sql_dump'); ?>
	
</body>
</html>