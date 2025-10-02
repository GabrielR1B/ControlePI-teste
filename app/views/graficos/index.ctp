<?php
	echo $this->Html->script('highchart/js/highcharts.js');
	echo $this->Html->script('highchart/js/modules/exporting.js');
	echo $this->Html->script('graficos.js');
?>

<style type="text/css">
	#alteraGrafico{
		
	}

	.grafico{
		width:900px;
		margin-bottom: 50px;
	}
</style>

<div class="actions">
</div>

<div class="graficos index" align="middle">

	
	<div id="grafico1" class="grafico"></div>
	<div id='alteraGrafico'>
		<h5> Quantidade mínima de pedidos para que o número seja exibido (em preto):<input type="text" id="numMin" style="width:20px"></h5>
	</div>
	<div id="grafico6" class="grafico"></div>
	<div id="grafico2" class="grafico"></div>
	<div id="grafico3" class="grafico"></div>
	<div id="grafico4" class="grafico"></div>
	

</div>