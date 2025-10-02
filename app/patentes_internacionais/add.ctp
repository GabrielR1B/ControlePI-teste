<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Patentes', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nova Patente', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Buscar Patentes', true), array('action' => 'search')); ?></li>
	</ul>
</div>
<h2><?php __('Adicionar Patente');?></h2>
<?php 
	echo $this->Form->create('PatenteInternacional',array('id'=>'form_patente','url' => array('controller' => 'patentes_internacionais', 'action' => 'add'))); 
?>
<fieldset>
	<div id="natureza_id"> 
		<?php echo $this->Form->input('natureza_id',array('id'=>'natureza_id_input','empty'=>'')); ?> 
	</div> 
		<div id="pasta"> 
			<?php echo $this->Form->input('pasta',array('id'=>'pasta')); ?> 
		</div>
		<div id="pasta_juridico"> 
			<?php echo $this->Form->input('pasta_juridico',array('id'=>'pasta_juridico','label'=>'Pasta do Jurídico')); ?> 
		</div>
		<div id="pct_id"> 
			<?php echo $this->Form->input('pct_id',array('label'=>'Número PCT','rows'=>'1','id'=>'num_pct_input')); ?> 
		</div>
		<div id="pais_id"> 
			<?php echo $this->Form->input('pais_id',array('id'=>'pais_id_input','empty'=>'')); ?> 
		</div>
		<div id="num_pedido"> 
			<?php echo $this->Form->input('num_pedido',array('label'=>'Número do Pedido','type'=>'text')); ?> 
		</div> 
		<div id="titulo"> 
			<?php echo $this->Form->input('titulo', array('type' => 'text')); ?> 
		</div>
		<div id="data"> 
			<?php echo $this->Form->input('data', array('separator' => '/ ', 'dateFormat' => 'DMY', 'minYear' => date('Y') - 70, 'maxYear' => date('Y') + 5 )); ?> 
		</div>
		<div id="tecnologia_id"> 
			<?php echo $this->Form->input('tecnologia_id',array('label'=>'Número Pedido Nacional','rows'=>'1','id'=>'tecnologia_id_input')); ?> 
		</div>
		<div id="num_publicacao"> 
			<?php echo $this->Form->input('num_publicacao',array('label'=>'Número de Publicação','id'=>'num_publicacao')); ?> 
		</div>
		<div id="escritorio_id"> 
			<?php echo $this->Form->input('escritorio_id',array('default'=>'1','id'=>'escritorio_id')); ?> 
		</div>
		<div id="area_id"> 
			<?php echo $this->Form->input('area_id',array('empty'=>'','id'=>'area_id')); ?> 
		</div>
		<div id="redator_id"> 
			<?php echo $this->Form->input('redator_id',array('empty'=>'','id'=>'redator_id')); ?> 
		</div>
		<div id="num_processo_sei"> 
			<?php echo $this->Form->input('num_processo_sei',array('id'=>'num_processo_sei','label'=>'Número do Processo SEI')); ?> 
		</div>
		<div id="status_id"> 
			<?php echo $this->Form->input('status_id',array('id'=>'status_id')); ?> 
		</div>
		<div id="status_transferencia_id"> 
			<?php echo $this->Form->input('status_transferencia_id',array('label'=>'Status da Transferência','id'=>'status_transferencia_id','options'=>$status_transferencias)); ?> 
			<?php echo $this->Form->input('observacoes_status_transferencia',array('label'=>'')); ?>
		</div>
		<div id="numero_pasta_setor_regularizacao">
			<?php echo $this->Form->input('numero_pasta_setor_regularizacao',array('label'=>'Pasta no Setor de Regularização')); ?> 
		</div>
		<div id="observacoes"> 
			<?php echo $this->Form->input('observacoes',array('label'=>'Observações')); ?> 
		</div>
</fieldset>
	
<?php echo $this->Form->end(__('Submit', true));?>


<script type="text/javascript"> 

	$(document).ready(function () {
	    $("#tecnologia_id_input").tokenInput('/controle-pi/tecnologias/ajaxPedidos/', {
	    	hintText: "Digite o número da patente nacional",
	    	preventDuplicates: true,
	    	propertyToSearch: "num_pedido",
	    	resultsFormatter: function(item){ return "<li>" + item.num_pedido + "<p>" + item.name + "</li>" }
	    });
	    
	    $("#num_pct_input").tokenInput('/controle-pi/patentes_internacionais/ajaxPct/', {
	    	hintText: "Digite o número da patente nacional",
	    	preventDuplicates: true,
	    	propertyToSearch: "num_pedido",
	    	tokenLimit: 1,
	    	resultsFormatter: function(item){ return "<li>" + item.num_pedido + "<p>" + item.name + "</li>" }
	    });


/*
	    $("#num_pct_input").tokenInput('/controle-pi/patentes_internacionais/ajaxPct/', {
			hintText: "Digite o número do PCT",
			preventDuplicates: true,
			propertyToSearch: "num_pct",
			tokenValue:"num_pct",
			tokenLimit: 1,
			resultsFormatter: function(item){ return "<li>" + item.num_pct + "<p>" + item.name + "</li>" }
		});*/
	});

	$(document).ready(function () {
	    $("#pais_id_input").tokenInput('/controle-pi/paises/ajaxPaises/', {
	    	hintText: "Digite o nome do país",
	    	preventDuplicates: true,
	    	propertyToSearch: "nome",
	    	tokenLimit: 1,
	    	resultsFormatter: function(item){ return "<li>" + item.nome + "</li>" }
	    });
	});

	$("#natureza_id").change(handleNewSelection);

	function hideAllInputs() {
    	$("#pasta").hide();
    	$("#pasta_juridico").hide();
    	$("#area_id").hide();
    	$("#redator_id").hide();
    	$("#num_processo_sei").hide();
    	$("#pct_id").hide();
    	$("#titulo").hide();
    	$("#data").hide();
    	$("#tecnologia_id").hide();
    	$("#num_publicacao").hide();
    	$("#escritorio_id").hide();
    	$("#status_id").hide();
    	$("#status_transferencia_id").hide();
    	$("#pais_id").hide();
    	$("#numero_pasta_setor_regularizacao").hide();
    	$("#num_pedido").hide();
    	$("#observacoes").hide();
	}

	function handleNewSelection () {

		var natureza_id = document.getElementById("natureza_id_input").value;

		switch(natureza_id){
			case '1':
				showPctInputs();
			  	break;
			case '2':
				showFaseNacionalInputs()
			  	break;
			case '3':
				showDepositoDiretoInputs();
			  	break;
			case '4':
				showProvisionalInputs();
			  	break;
			case '5':
				showDepositoDiretoInputs();
			  	break;
			case '6':
				showDepositoDiretoInputs();
			  	break;
			default:
				hideAllInputs();
		}

		document.getElementById("form_patente").reset();

		document.getElementById("natureza_id_input").value = natureza_id;

	}

	function showPctInputs(){
		hideAllInputs();
		$("#pasta").show();
		$("#pasta_juridico").show();
    	$("#titulo").show();
    	$("#data").show();
    	$("#tecnologia_id").show();
    	$("#num_publicacao").show();
    	$("#escritorio_id").show();
    	$("#area_id").show();
    	$("#redator_id").show();
    	$("#num_processo_sei").show();
    	$("#status_id").show();
    	$("#status_transferencia_id").show();
    	$("#num_pedido").show();
    	$("#numero_pasta_setor_regularizacao").show();
    	$("#observacoes").show();    	
	}

	function showFaseNacionalInputs(){
		hideAllInputs();
    	$("#pct_id").show();
    	$("#pasta").show();
    	$("#pasta_juridico").show();
    	$("#titulo").show();
    	$("#data").show();
    	$("#escritorio_id").show();
    	$("#area_id").show();
    	$("#redator_id").show();
    	$("#num_processo_sei").show();
    	$("#status_id").show();
    	$("#status_transferencia_id").show();
    	$("#pais_id").show();
    	$("#num_pedido").show();
    	$("#numero_pasta_setor_regularizacao").show();
    	$("#observacoes").show();
	}

	function showDepositoDiretoInputs(){
		hideAllInputs();
		$("#pasta").show();
		$("#pasta_juridico").show();
    	$("#titulo").show();
    	$("#data").show();
    	$("#tecnologia_id").show();
    	$("#escritorio_id").show();
    	$("#area_id").show();
    	$("#redator_id").show();
    	$("#num_processo_sei").show();
    	$("#status_id").show();
    	$("#status_transferencia_id").show();
    	$("#pais_id").show();
    	$("#num_pedido").show();
    	$("#numero_pasta_setor_regularizacao").show();
    	$("#observacoes").show();
	}

	function showProvisionalInputs(){
		hideAllInputs();
		$("#pasta").show();
		$("#pasta_juridico").show();
    	$("#titulo").show();
    	$("#data").show();
    	$("#tecnologia_id").show();
    	$("#escritorio_id").show();
    	$("#area_id").show();
    	$("#redator_id").show();
    	$("#num_processo_sei").show();
    	$("#status_id").show();
    	$("#status_transferencia_id").show();
    	$("#pais_id").show();
    	$("#num_pedido").show();
    	$("#numero_pasta_setor_regularizacao").show();
    	$("#observacoes").show();
	}
	
	hideAllInputs();
</script>
