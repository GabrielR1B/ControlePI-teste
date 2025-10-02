<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(('Listar Knowhow'), array('action' => 'index'));?></li>
	</ul>
</div>

<div class="knowhows form">
<?php echo $this->Form->create('Knowhow');?>
	<fieldset>
		<legend>Adicionar Knowhow</legend>
	<?php
		echo $this->Form->input('titulo');
		echo $this->Form->input('pasta');
		echo $this->Form->input('pasta_juridico');
		echo $this->Form->input('data');
		echo $this->Form->input('num_processo_sei', array('label'=>'Número do Processo SEI'));
		echo $this->Form->input('criadores');
		echo $this->Form->input('titular_id', array('empty' => ''));
		echo $this->Form->input('area_id', array('empty' => ''));
		echo $this->Form->input('status_id', array('empty' => ''));
		echo $this->Form->input('observacoes');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>