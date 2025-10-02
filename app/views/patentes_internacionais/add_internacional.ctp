<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Patentes', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nova Patente', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Buscar Patentes', true), array('action' => 'search')); ?></li>
	</ul>
</div>

<div class="tecnologias form">
<h2><?php __('Adicionar Patente');?></h2>
<?php echo $this->Form->create('PatentesInternacional',array());?>

	<fieldset id="form-internacional">

	<label>Número de patentes</label>
	<select id="numeroPatentes" onchange="geraFormulario()">
  		<option></option>
  		<option>1</option>
  		<option>2</option>  
  		<option>3</option>
  		<option>4</option>
  		<option>5</option>
  		<option>6</option>
  		<option>7</option>
  		<option>8</option>
  		<option>9</option>
  		<option>10</option>
  		<option>11</option>
  		<option>12</option>
	</select><p>
	<?php
		echo $this->Form->input('pasta');
		echo $this->Form->input('pasta_juridico');
		echo $this->Form->input('data', array('label'=>'Data de Prioridade', 'type'=>'text','class'=>'data'));
		echo $this->Form->input('tecnologia_id',array('label'=>'Número Pedido Nacional','id'=>'tecnologia_id','rows'=>'1'));
		echo $this->Form->input('data_internacional', array('label'=>'Data do Depósito Internacional', 'type'=>'text','class'=>'data'));
		
		echo $this->Form->input('num_pct',array('label'=>'Número PCT','rows'=>'1'));
		echo $form->hidden('numeroPatentes', array('value' => $numeroPatentes));
		echo $this->Form->input('titulo', array('type' => 'text'));
		echo $this->Form->input('num_publicacao',array('label'=>'Número de Publicação'));
		echo $this->Form->input('escritorio_id');
		echo $this->Form->input('status_id');

		
		for ($i=1; $i<=$numeroPatentes; $i++) {
			echo "<hr><hr><hr>";
			echo $this->Form->input('pais.'.$i,array('label'=>'País'.$i, 'class'=>'pais', 'name'=>"data[PatentesInternacional][pais][$i]"));
			echo $this->Form->input('num_pedido.'.$i,array('label'=>'Número Pedido'.$i,'id'=>'num_pedido','rows'=>1, 'name'=>"data[PatentesInternacional][num_pedido][$i]"));
			echo $this->Form->input('data_concessao.'.$i, array('label'=>'Data Concessao'.$i, 'type'=>'text','class'=>'data','name'=>"data[PatentesInternacional][data_concessao][$i]"));
			echo $this->Form->input('status_id', array('label'=>'Status'.$i, 'name'=>"data[PatentesInternacional][status][$i]"));
		}
	?>
	</fieldset>
	
<?php echo $this->Form->end(__('Submit', true));?>
</div>
			<div class ='input text area' >

			</div>


<script type="text/javascript"> 

	$(document).ready(function () {
	    $("#tecnologia_id").tokenInput('/controle-pi/tecnologias/ajaxPedidos/', {
	    	hintText: "Digite o número da patente nacional",
	    	preventDuplicates: true,
	    	propertyToSearch: "num_pedido",
	    	tokenLimit: 1,
	    	resultsFormatter: function(item){ return "<li>" + item.num_pedido + "<p>" + item.name + "</li>" }
	    });
	});

	$(document).ready(function () {
	    $(".pais").tokenInput('/controle-pi/paises/ajaxPaises/', {
	    	hintText: "Digite o nome do país",
	    	preventDuplicates: true,
	    	propertyToSearch: "nome",
	    	tokenLimit: 1,
	    	resultsFormatter: function(item){ return "<li>" + item.nome + "</li>" }
	    });
	});

	jQuery(function($){
	   $(".data").mask("99 /99 /9999");
	});


function geraFormulario(){
	var mylist=document.getElementById("numeroPatentes");
	window.location="./add_internacional/" + mylist.options[mylist.selectedIndex].text;
	//window.location("./addInternacional/" + mylist.options[mylist.selectedIndex].text);
}


</script>
