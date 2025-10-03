<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Marcas', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nova Marca', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Buscar Marca', true), array('action' => 'search')); ?></li>
	</ul>
</div>

<div class="marcas form">
<h2><?php __('Adicionar Marca');?></h2>
	
<?php echo $this->Form->create('Marca');?>
	<fieldset>
	<?php
		//Seção 1 - Dados básicos da marca'
		echo $this->Form->input('nome', array('type' => 'text'));
		echo $this->Form->input('processo', array('type' => 'int'));
		echo $this->Form->input('pasta', array('type' => 'text'));
		echo $this->Form->input('pasta_juridico', array('type' => 'text'));
		echo $this->Form->input('data', array('separator' => ' . ', 'dateFormat' => 'DMY', 'minYear' => date('Y') - 70, 'maxYear' => date('Y') + 2 ));
		//Seção 2 - Dados adicionais
		echo $this->Form->input('num_processo_sei');
		echo $this->Form->input('naturezamarca_id', array('label'=>'Natureza'));
		echo $this->Form->input('apresentacao_id',array('label'=>'Apresentação'));
		echo $this->Form->input('andamento_id');
		echo $this->Form->input('status_id',array('label'=>'StatusPI'));
		echo $this->Form->input('classe', array('type' => 'text'));
		echo $this->Form->input('requerentes');
		//Seção 3 - Dados de Transferência
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