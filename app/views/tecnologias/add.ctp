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
		echo $this->Form->input('prioridade_interna_id', array('empty' => '', 'id'=>'prioridade_interna_id', 'label' => 'Prioridade Interna'));
		echo $this->Form->input('naturezatecnologia_id', array('empty' => '', 'label' => 'Natureza' ));
		echo $this->Form->input('redator_id', array('empty' => '', 'label' => 'Redator'));
		echo $this->Form->input('area_id', array('empty' => ''));
		echo $this->Form->input('num_processo_sei', array('label'=>'Número do Processo SEI'));
		echo $this->Form->input('tem_sisgen',array('empty' => '','label'=>'Acesso ao PG/CTA (patrimônio genético/conhecimento tradicional associado)?','options'=> array('0'=>'Não','1'=>'Sim')));
		echo $this->Form->input('num_sisgen',array('div'=>array('style'=>'display:none;'),'label' => 'Número de cadastro no SisGen'));
		echo $this->Form->input('status_id');
	?>
		<div class="obs">Observação: As palavras-chave e os autores deverão ser adicionados após a adição da tecnologia.</div>
	</fieldset>
	
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
