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
		echo $this->Form->input('termo_de_participacao');
		echo $this->Form->input('declaracao_do_inventor');
		echo $this->Form->input('declaracao_de_cotitularidade');
		echo $this->Form->input('contrato_de_cotitularidade');
		echo $this->Form->input('observacoes',array('label'=>'Observações'));
		// Seção 3 - Dados de Transferência
		echo '<label>Status da Transferência</label>';
		echo $this->Form->input('st_ofertada',array('label'=>'Ofertada'));
		echo $this->Form->input('st_em_negociacao',array('label'=>'Em Negociação'));
		echo $this->Form->input('st_licenciada',array('label'=>'Licenciada/Transferida'));
		echo $this->Form->input('st_parceria',array('label'=>'Parceria'));
		echo $this->Form->input('st_contrato_rescindido',array('label'=>'Contrato Rescindido'));
		echo $this->Form->input('st_vitrine_tecnologica',array('label'=>'Vitrine Tecnológica'));
		echo $this->Form->input('observacoes_transferencia',array('label'=>'Observações da Transferência'));
			?>
	    <!-- Seção 4 - Titulares,  Departamentos e Unidades -->
		<div class="obs">Observação: As palavras-chave e os autores deverão ser adicionados após a adição da tecnologia.</div>
		<hr>
		<h4>Inventores</h4>
		<div class="input text">
    		<label for="buscar_inventor">Buscar Inventor</label>
    		<input type="text" id="buscar_inventor" />
		</div>

		<ul id="lista_inventores_selecionados">
   		 </ul>

		<div id="inventores_hidden_container">
    	<?php
        echo $this->Form->input('Inventor.Inventor', array('type' => 'hidden'));
   			 ?>
		</div>
		<h4>Departamentos</h4>
		<div class = "input text">
			<label for ="buscar_departamento">Buscar Departamento</label>
			<input type="text" id="buscar_departamento"/>
		</div>
		<ul id="lista_departamentos_selecionados">
		</ul>
		<div id="departamentos_hidden_container">
			<?php
			echo $this->Form->input('Departamento.Departamento', array('type' => 'hidden'));
			?>
		</div>

<?php
echo $this->Form->end('Salvar Tecnologia');
	</fieldset>	
<?php echo $this->Form->end(__('Submit', true));?>
</div>
			<div class ='input text area' 

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
	$(document).ready(function() {
		$("#certificado_adicao_id").tokenInput('/controle-pi/tecnologias/ajaxCertificados/', {
			hintText: "Digite o número do certificado de adição",
			preventDuplicates: true,
			propertyToSearch: "num_certificado",
			tokenLimit: 1,
			resultsFormatter: function(item){ return "<li>" + item.num_certificado + "<p>" + item.titulo + "</li>" }
		});

		//Controla a exibição do input do número do certificado de adição
	    $("#TecnologiaCertificadoAdicaoId").change(function() {
	    	ExibirNumeroCertificadoAdicao(this.value);
	    });
	});

	function ExibirNumeroCertificadoAdicao(temCertificadoAdicao){
		if(temCertificadoAdicao == 1){
	    	$( "#TecnologiaCertificadoAdicaoId").parent().show();
	    }else{
	    	$("#TecnologiaCertificadoAdicaoId").parent().hide();
	    	$("#TecnologiaCertificadoAdicaoId").val('');    		
	    }
	}
	function ExibirNumeroSisGen(temNumeroSisGen){
		if(temNumeroSisGen == 1){
	    	$( "#TecnologiaNumSisgen").parent().show();
	    }else{
	    	$("#TecnologiaNumSisgen").parent().hide();
	    	$("#TecnologiaNumSisgen").val('');    		
	    }
	}
	//Função para associar inventor
	$("#buscar_inventor").autocomplete({
    source: "<?php echo $this->Html->url( array('controller'=>'tecnologias', 'action'=>'ajaxListarInventores') ) ?>",
    minLength: 2,
    select: function( event, ui ) {
        // ui.item.id e ui.item.nome vêm da resposta AJAX do autocomplete
        adicionarInventorNaLista( ui.item.id, ui.item.nome );
        
        // Limpa o campo de busca para o usuário poder adicionar outro
        $(this).val(''); 
        return false;
    }
	});

	// Função para adicionar o inventor selecionado na lista de inventores da tecnologia
	function adicionarInventorNaLista(id, nome) {
    
    var itemVisual = "<li>" + nome + " <a href='#' class='remover-inventor' data-id='" + id + "'> (remover)</a></li>";
    $("#lista_inventores_selecionados").append(itemVisual);
    var inputOculto = "<input type='hidden' name='data[Inventor][Inventor][]' value='" + id + "' id='inventor_" + id + "'>";
    $("#inventores_hidden_container").append(inputOculto);
}

	$(document).on('click', '.remover-inventor', function(e){
    e.preventDefault();
    var inventorId = $(this).data('id');
    $('#inventor_' + inventorId).remove();
    $(this).parent('li').remove();
});

	//Função para associar departamento
	$("#buscar_departamento").autocomplete({
	source: "<?php echo $this->Html->url( array('controller'=>'tecnologias', 'action'=>'ajaxListarDepartamentos') ) ?>",
	minLength: 2,
	select: function( event, ui ) {
		// ui.item.id e ui.item.nome vêm da resposta AJAX do autocomplete
		adicionarDepartamentoNaLista( ui.item.id, ui.item.nome );
		
		// Limpa o campo de busca para o usuário poder adicionar outro
		$(this).val(''); 
		return false;
	}
	});
	// Função para adicionar o departamento selecionado na lista de departamentos da tecnologia
	function adicionarDepartamentoNaLista(id, nome) {
	
	var itemVisual = "<li>" + nome + " <a href='#' class='remover-departamento' data-id='" + id + "'> (remover)</a></li>";
	$("#lista_departamentos_selecionados").append(itemVisual);
	var inputOculto = "<input type='hidden' name='data[Departamento][Departamento][]' value='" + id + "' id='departamento_" + id + "'>";
	$("#departamentos_hidden_container").append(inputOculto);
	}
	$(document).on('click', '.remover-departamento', function(e){
	e.preventDefault();
	var departamentoId = $(this).data('id');
	$('#departamento_' + departamentoId).remove();
	$(this).parent('li').remove();
});
</script>
