<!-- Carregando o script de associaçoes -->
<?php echo $this->Html->script('associacoes'); ?>
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
		// Seção 1 - Dados básicos
		echo $this->Form->input('titulo', array('label'=>'Título'));
		echo $this->Form->input('pasta');
		echo $this->Form->input('num_pedido', array('label'=>'Número do pedido'));
		echo $this->Form->input('funcionalidade');
		echo $this->Form->input('pasta_juridico',array('label'=>'Pasta Jurídico'));
		echo $this->Form->input('data', array('separator' => ' . ', 'dateFormat' => 'DMY', 'minYear' => date('Y') - 70, 'maxYear' => date('Y') + 2 ));
		// Seção 2 - Dados adicionais
		echo $this->Form->input('num_processo_sei', array('label'=>'Número do Processo SEI'));
		echo $this->Form->input('criadores');
		echo $this->Form->input('status_id');
		echo $this->Form->input('observacoes', array('label'=>'Observações'));
		echo '<hr>';
		// Seção 3 - Dados de Transferência
		echo '<label>Status da Transferência</label>';
		echo $this->Form->input('st_ofertada',array('label'=>'Ofertada'));
		echo $this->Form->input('st_em_negociacao',array('label'=>'Em Negociação'));
		echo $this->Form->input('st_licenciada',array('label'=>'Licenciada/Transferida'));
		echo $this->Form->input('st_parceria',array('label'=>'Parceria'));
		echo $this->Form->input('st_contrato_rescindido',array('label'=>'Contrato Rescindido'));
		echo $this->Form->input('st_vitrine_tecnologica',array('label'=>'Vitrine Tecnológica'));
		echo $this->Form->input('observacoes_transferencia',array('label'=>'Observações da Transferência'));
		echo '<hr>';
		// Seção 4, Titulares, Departaments, etc...
		echo $this->FormGenerator->section('Titular','Titular','buscar_titular','lista_titulares_selecionados','titulares_hidden_container');
        echo $this->FormGenerator->section('Inventor','Inventor','buscar_inventor','lista_inventores_selecionados','inventores_hidden_container');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
<script type ="text/javascript">
    // Inicializa a exibição correta dos inputs ao carregar a página
    $(document).ready(function() {
        associacaoAutocomplete(
            'Titular',
            'buscar_titular',
            'lista_titulares_selecionados',
            'titulares_hidden_container',
            '<?php echo $this->Html->url(["controller" => "tecnologias", "action" => "ajaxListarTitulares"]); ?>'
        );
        associacaoAutocomplete(
            'Inventor',
            'buscar_inventor',
            'lista_inventores_selecionados',
            'inventores_hidden_container',
            '<?php echo $this->Html->url(["controller" => "tecnologias", "action" => "ajaxListarInventores"]); ?>'
        );
});
</script>
</div>