<?php 
$anos = array();
$marcas = array();
$marcasFinal = array();

foreach($resultado as $item) {
	array_push($anos, $item[0]['ano']);
	array_push($marcas, $item[0]['total']);
}

$thisYear = (int)date (Y);
$posMarca = 0;
for ($i=1992; $i <= $thisYear; $i++) { 
	$istr = (string)$i;
	if (strcmp($anos[$posMarca], $istr) == 0){
		array_push($marcasFinal, $marcas[$posMarca]);
		$posMarca++;
	}
	else {
		array_push($marcasFinal, '0');
	}
}

$marcasFinal = implode(",", $marcasFinal);

//$saida = sprintf('{"categorias":[%s], "series":[%s]}', $anos , $marcas);
$saida = sprintf('{"series":[%s]}', $marcasFinal);
echo $saida;
?>