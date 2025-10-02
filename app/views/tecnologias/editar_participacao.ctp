<div class="tecnologias form">
<h2><?php __('Editar Patente');?></h2>

<?php
	echo $this->Form->create('TecnologiaTitular', array('url' => array('controller' => 'tecnologias', 'action' => 'editar_participacao')));
?>

	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('tecnologia_id', array('disabled'=>'disabled'));
		echo $this->Form->input('titular_id', array('disabled'=>'disabled'));
		echo $this->Form->input('percentual');
		echo $this->Form->end('Salvar');
	?>
	</fieldset>
</div>