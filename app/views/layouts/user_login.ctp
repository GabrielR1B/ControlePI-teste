<?php include('header.ctp'); ?>
</head>

<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $this->Html->link(__('CTIT | Controle de PI', true), '/'); ?></h1>			
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
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>