/**
 * View file for adding a new Software entry.
 *
 * This form allows users to input details for a new software record, including:
 * - Título (Title)
 * - Pasta (Folder)
 * - Pasta Jurídico (Legal Folder)
 * - Número do pedido (Order Number)
 * - Data (Date) with a selectable year range
 * - Número do Processo SEI (SEI Process Number)
 * - Funcionalidade (Functionality)
 * - Criadores (Creators)
 * - Status (Status, selected by status_id)
 * - Observações (Observations)
 * - Status da Transferência (Transfer Status), including:
 *   - Ofertada
 *   - Em Negociação
 *   - Licenciada/Transferida
 *   - Parceria
 *   - Contrato Rescindido
 *   - Vitrine Tecnológica
 *   - Observações da Transferência (Transfer Observations)
 *
 * The sidebar provides navigation links to list all softwares and search for a software.
 *
 * @file    app/softwares/add.ctp
 * @package View
 * @var     \App\View\AppView $this
 */
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
		echo '<label>Status da Transferência</label>';
		echo $this->Form->input('st_ofertada',array('label'=>'Ofertada'));
		echo $this->Form->input('st_em_negociacao',array('label'=>'Em Negociação'));
		echo $this->Form->input('st_licenciada',array('label'=>'Licenciada/Transferida'));
		echo $this->Form->input('st_parceria',array('label'=>'Parceria'));
		echo $this->Form->input('st_contrato_rescindido',array('label'=>'Contrato Rescindido'));
		echo $this->Form->input('st_vitrine_tecnologica',array('label'=>'Vitrine Tecnológica'));
		echo $this->Form->input('observacoes_transferencia',array('label'=>'Observações da Transferência'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>