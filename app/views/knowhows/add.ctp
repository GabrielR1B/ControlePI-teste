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
		// Seção 1 - Dados básicos do knowhow
		echo $this->Form->input('titulo');
		echo $this->Form->input('pasta');
		echo $this->Form->input('pasta_juridico');
		echo $this->Form->input('num_processo_sei', array('label'=>'Número do Processo SEI'));
		echo $this->Form->input('data', array('separator' => ' . ', 'dateFormat' => 'DMY', 'minYear' => date('Y') - 70, 'maxYear' => date('Y') + 2 ));
		// Seção 2 - Dados adicionais
		echo $this->Form->input('justificativa_cotitularidade');
		echo $this->Form->input('contrato_cotitularidade', array('label'=>'Contrato de Cotitularidade'));
		echo $this->Form->input('criadores');
		echo $this->Form->input('titular_id', array('empty' => ''));
		echo $this->Form->input('area_id', array('empty' => ''));
		echo $this->Form->input('status_id', array('empty' => ''));

		// Seção 3 - Dados de Transferência
		echo '<label>Status da Transferência</label>';
		echo $this->Form->input('st_ofertada',array('label'=>'Ofertada'));
		echo $this->Form->input('st_em_negociacao',array('label'=>'Em Negociação'));
		echo $this->Form->input('st_licenciada',array('label'=>'Licenciada/Transferida'));
		echo $this->Form->input('st_parceria',array('label'=>'Parceria'));
		echo $this->Form->input('st_contrato_rescindido',array('label'=>'Contrato Rescindido'));
		echo $this->Form->input('st_vitrine_tecnologica',array('label'=>'Vitrine Tecnológica'));
		echo $this->Form->input('observacoes_transferencia',array('label'=>'Observações da Transferência'));
		echo $this->Form->input('observacoes');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
