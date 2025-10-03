<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Patentes', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Buscar Patentes', true), array('action' => 'search')); ?></li>
	</ul>
</div>

<div class="tecnologias form">
<h2><?php __('Adicionar Patente');?></h2>
	
<?php echo $this->Form->create('Tecnologia',array());?>
	<fieldset>
	<?php
		// Seção 1 - Dados básicos da tecnologia
		echo $this->Form->input('titulo', array('type' => 'text'));
		echo $this->Form->input('num_pedido', array('type' => 'text'));
		echo $this->Form->input('pasta', array('type' => 'text'));
		echo $this->Form->input('pasta_juridico', array('type' => 'text'));
		echo $this->Form->input('resumo');
		echo '<div class="input"><label>Número de Reivindicações</label>';
		echo $this->Form->text('num_reivindicacoes', array('type'=>'number'));
		echo '</div>';
		echo $this->Form->input('reivindicacoes',array('label'=>'Quadro Reivindicatório'));
		echo $this->Form->input('data', array('separator' => ' . ', 'dateFormat' => 'DMY', 'minYear' => date('Y') - 70, 'maxYear' => date('Y') + 2 ));
		// Seção 2 - Dados adicionais
		echo $this->Form->input('prioridade_interna_id', array('empty' => '', 'id'=>'prioridade_interna_id', 'label' => 'Prioridade Interna'));
		echo $this->Form->input('certificado_adicao_id', array('empty' => '', 'id'=>'certificado_adicao_id', 'label' => 'Certificado de Adição','rows'=>'1'));
		echo $this->Form->input('pais_id', array('empty' => '', 'label' => 'País'));
		echo $this->Form->input('naturezatecnologia_id', array('empty' => '', 'label' => 'Natureza' ));
		echo $this->Form->input('acompanhamento');
		echo $this->Form->input('redator_id', array('empty' => '', 'label' => 'Redator'));
		echo $this->Form->input('area_id', array('empty' => ''));
		echo $this->Form->input('num_processo_sei', array('label'=>'Número do Processo SEI'));
		echo $this->Form->input('tem_sisgen',array('empty' => '','label'=>'Acesso ao PG/CTA (patrimônio genético/conhecimento tradicional associado)?','options'=> array('0'=>'Não','1'=>'Sim')));
		echo $this->Form->input('num_sisgen',array('div'=>array('style'=>'display:none;'),'label' => 'Número de cadastro no SisGen'));
		echo $this->Form->input('andamento_id');
		echo $this->Form->input('status_id', array('label'=>'Status PI'));
		// Seção 3 - Documentos
		echo $this->Form->input('termo_de_participacao');
		echo $this->Form->input('declaracao_do_inventor');
		echo $this->Form->input('declaracao_de_cotitularidade');
		echo $this->Form->input('contrato_de_cotitularidade');
		echo $this->Form->input('observacoes',array('label'=>'Observações'));
		// Seção 4 - Dados de Transferência
		echo '<label>Status da Transferência</label>';
		echo $this->Form->input('st_ofertada',array('label'=>'Ofertada'));
		echo $this->Form->input('st_em_negociacao',array('label'=>'Em Negociação'));
		echo $this->Form->input('st_licenciada',array('label'=>'Licenciada/Transferida'));
		echo $this->Form->input('st_parceria',array('label'=>'Parceria'));
		echo $this->Form->input('st_contrato_rescindido',array('label'=>'Contrato Rescindido'));
		echo $this->Form->input('st_vitrine_tecnologica',array('label'=>'Vitrine Tecnológica'));
		echo $this->Form->input('observacoes_transferencia',array('label'=>'Observações da Transferência'));
			?>
		<div class="obs">Observação: As palavras-chave e os autores deverão ser adicionados após a adição da tecnologia.</div>
	</fieldset>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Patentes', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Buscar Patentes', true), array('action' => 'search')); ?></li>
	</ul>
</div>

<div class="tecnologias form">
<h2><?php __('Adicionar Patente');?></h2>
	
<?php echo $this->Form->create('Tecnologia',array());?>
	<fieldset>
	<?php
		// Seção 1 - Dados básicos da tecnologia
		echo $this->Form->input('titulo', array('type' => 'text'));
		echo $this->Form->input('num_pedido', array('type' => 'text'));
		echo $this->Form->input('pasta', array('type' => 'text'));
		echo $this->Form->input('pasta_juridico', array('type' => 'text'));
		echo $this->Form->input('resumo');
		echo '<div class="input"><label>Número de Reivindicações</label>';
		echo $this->Form->text('num_reivindicacoes', array('type'=>'number'));
		echo '</div>';
		echo $this->Form->input('reivindicacoes',array('label'=>'Quadro Reivindicatório'));
		echo $this->Form->input('data', array('separator' => ' . ', 'dateFormat' => 'DMY', 'minYear' => date('Y') - 70, 'maxYear' => date('Y') + 2 ));
		// Seção 2 - Dados adicionais
		echo $this->Form->input('prioridade_interna_id', array('empty' => '', 'id'=>'prioridade_interna_id', 'label' => 'Prioridade Interna'));
		echo $this->Form->input('certificado_adicao_id', array('empty' => '', 'id'=>'certificado_adicao_id', 'label' => 'Certificado de Adição','rows'=>'1'));
		echo $this->Form->input('pais_id', array('empty' => '', 'label' => 'País'));
		echo $this->Form->input('naturezatecnologia_id', array('empty' => '', 'label' => 'Natureza' ));
		echo $this->Form->input('acompanhamento');
		echo $this->Form->input('redator_id', array('empty' => '', 'label' => 'Redator'));
		echo $this->Form->input('area_id', array('empty' => ''));
		echo $this->Form->input('num_processo_sei', array('label'=>'Número do Processo SEI'));
		echo $this->Form->input('tem_sisgen',array('empty' => '','label'=>'Acesso ao PG/CTA (patrimônio genético/conhecimento tradicional associado)?','options'=> array('0'=>'Não','1'=>'Sim')));
		echo $this->Form->input('num_sisgen',array('div'=>array('style'=>'display:none;'),'label' => 'Número de cadastro no SisGen'));
		echo $this->Form->input('andamento_id');
		echo $this->Form->input('status_id', array('label'=>'Status PI'));
		// Seção 3 - Documentos
		echo $this->Form->input('termo_de_participacao');
		echo $this->Form->input('declaracao_do_inventor');
		echo $this->Form->input('declaracao_de_cotitularidade');
		echo $this->Form->input('contrato_de_cotitularidade');
		echo $this->Form->input('observacoes',array('label'=>'Observações'));
		// Seção 4 - Dados de Transferência
		echo '<label>Status da Transferência</label>';
		echo $this->Form->input('st_ofertada',array('label'=>'Ofertada'));
		echo $this->Form->input('st_em_negociacao',array('label'=>'Em Negociação'));
		echo $this->Form->input('st_licenciada',array('label'=>'Licenciada/Transferida'));
		echo $this->Form->input('st_parceria',array('label'=>'Parceria'));
		echo $this->Form->input('st_contrato_rescindido',array('label'=>'Contrato Rescindido'));
		echo $this->Form->input('st_vitrine_tecnologica',array('label'=>'Vitrine Tecnológica'));
		echo $this->Form->input('observacoes_transferencia',array('label'=>'Observações da Transferência'));
			?>
		<div class="obs">Observação: As palavras-chave e os autores deverão ser adicionados após a adição da tecnologia.</div>
	</fieldset>
		<br><br><br><strong><label>Titulares</label></strong>
	<div id="lista_titulares">
		<ul style="width: 50%;">
		<?php if ( !empty($titulares)){ ?>
			<?php $count = count($titulares) ?>

				<?php foreach ($titulares as $titular):	?>
					<li>
						<?= $titular['nome'] .'<span id="percentual" style="margin-left:0px;"><a href="../editar_participacao/'.$titular['TecnologiasTitular']['id'].'" style="background-image: none !important; float: right; width: 160px; display: inline;">Participação: ' .  $titular['TecnologiasTitular']['percentual'] . ($titular['TecnologiasTitular']['percentual'] ? '%' : '') .'</a></span>';	?>
						<a id="titular_button" href="javascript:void(0);" name="<?php echo $titular['id']; ?>"></a>
					</li>				
				<?php endforeach; ?>
		<?php }else{ ?>
			<li>Não há titulares associados a esta tecnologia</li>
		<?php } ?>
		</ul>
	</div>
	<label for="buscar_titular">Adicionar Titular:</label>
	<input id="buscar_titular" />

	
<?php echo $this->Form->end(__('Submit', true));?>
</div>
			<div class ='input text area' >

			</div>

<script type="text/javascript"> 
	<!-- 
	function showMe (it1, it2, box) { 
	  var vis = (box.checked) ? "block" : "none"; 
	  document.getElementById(it1).style.display = vis;
	  document.getElementById(it2).style.display = vis;
	} 

    $(document).ready(function () {
	    $("#prioridade_interna_id").tokenInput('/controle-pi/tecnologias/ajaxPedidos/', {
	    	hintText: "Digite o número da patente nacional",
	    	preventDuplicates: true,
	    	propertyToSearch: "num_pedido",
	    	tokenLimit: 1,
	    	resultsFormatter: function(item){ return "<li>" + item.num_pedido + "<p>" + item.name + "</li>" }
	    });

	    //Controla a exibição do input do número do SisGen
	    $("#TecnologiaTemSisgen").change(function() {
	    	ExibirNumeroSisGen(this.value);
	    });
	});
	function ExibirNumeroSisGen(temNumeroSisGen){
		if(temNumeroSisGen == 1){
	    	$( "#TecnologiaNumSisgen").parent().show();
	    }else{
	    	$("#TecnologiaNumSisgen").parent().hide();
	    	$("#TecnologiaNumSisgen").val('');    		
	    }
	}
</script>