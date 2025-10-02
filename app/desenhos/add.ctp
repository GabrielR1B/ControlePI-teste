<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar DI', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('Buscar DI', true), array('action' => 'search')); ?></li>
	</ul>
</div>

<div class="desenhos form">
<?php echo $this->Form->create('Desenho');?>
	<fieldset>
		<legend><?php __('Adicionar Desenho Industrial'); ?></legend>
	<?php
		echo $this->Form->input('titulo');
		echo $this->Form->input('num_pedido');
		echo $this->Form->input('resumo');
		echo $this->Form->input('data');
		echo $this->Form->input('pasta');
		echo $this->Form->input('criadores');
		echo $this->Form->input('pasta_juridico');
		echo $this->Form->input('observacoes',array('label'=>'Observações'));
		echo $this->Form->input('num_processo_sei', array('label'=>'Número do Processo SEI'));
		echo $this->Form->input('area_id', array('empty'=>''));
		echo $this->Form->input('redator_id',array('label'=>'Redator', 'empty' => ''));
		echo $this->Form->input('andamento');
		echo $this->Form->input('status_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
