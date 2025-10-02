<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Softwares', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('Buscar Software', true), array('action' => 'search')); ?></li>
	</ul>
</div>
<div class="softwares form">
<?php echo $this->Form->create('Software');?>
	<fieldset>
		<legend><?php __('Adicionar Software'); ?></legend>
	<?php
		echo $this->Form->input('titulo', array('label'=>'Título'));
		echo $this->Form->input('pasta');
		echo $this->Form->input('pasta_juridico',array('label'=>'Pasta Jurídico'));
		echo $this->Form->input('num_pedido', array('label'=>'Número do pedido'));
		echo $this->Form->input('data', array('separator' => ' . ', 'dateFormat' => 'DMY', 'minYear' => date('Y') - 70, 'maxYear' => date('Y') + 2 ));
		echo $this->Form->input('num_processo_sei', array('label'=>'Número do Processo SEI'));
		echo $this->Form->input('funcionalidade');
		echo $this->Form->input('criadores');
		echo $this->Form->input('status_id');
		echo $this->Form->input('observacoes', array('label'=>'Observações'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>