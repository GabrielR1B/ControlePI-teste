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
	// Seção 1 - Dados básicos da tecnologia
		echo $this->Form->input('titulo');
		echo $this->Form->input('num_pedido');
		echo $this->Form->input('pasta');
		echo $this->Form->input('pasta_juridico');
		echo $this->Form->input('resumo');
		echo $this->Form->input('criadores');
		echo $this->Form->input('data');
		
	// Seção 2 - Dados adicionais
		echo $this->Form->input('justificativa_cotitularidade');
		echo $this->Form->input('contrato_cotitularidade');
		echo $this->Form->input('area_id', array('empty'=>''));
		echo $this->Form->input('num_processo_sei', array('label'=>'Número do Processo SEI'));
		echo $this->Form->input('redator_id',array('label'=>'Redator', 'empty' => ''));
		echo $this->Form->input('andamento_id');
		echo $this->Form->input('status_id',array('label'=>'Status PI'));
	// Seção 3 - Dados de Transferência
		echo '<label>Status da Transferência</label>';
		echo $this->Form->input('st_ofertada',array('label'=>'Ofertada'));
		echo $this->Form->input('st_em_negociacao',array('label'=>'Em Negociação'));
		echo $this->Form->input('st_licenciada',array('label'=>'Licenciada/Transferida'));
		echo $this->Form->input('st_parceria',array('label'=>'Parceria'));
		echo $this->Form->input('st_contrato_rescindido',array('label'=>'Contrato Rescindido'));
		echo $this->Form->input('st_vitrine_tecnologica',array('label'=>'Vitrine Tecnológica'));
		echo $this->Form->input('observacoes_transferencia',array('label'=>'Observações da Transferência'));
		echo '<div class="obs">Observação: As palavras-chave e os autores deverão ser adicionados após a adição do desenho industrial.</div>';
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
