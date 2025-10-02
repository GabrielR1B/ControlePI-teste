<?php 

$anos = array();
$desenhos = array();
$desenhosFinal = array();

foreach($resultado as $item) {
	array_push($anos, $item[0]['ano']);
	array_push($desenhos, $item[0]['total']);
}

$thisYear = (int)date (Y);
$posDesenho = 0;
for ($i=1992; $i <= $thisYear; $i++) { 
	$istr = (string)$i;
	if (strcmp($anos[$posDesenho], $istr) == 0){
		array_push($desenhosFinal, $desenhos[$posDesenho]);
		$posDesenho++;
	}
	else {
		array_push($desenhosFinal, '0');
	}
}

//$anos = implode(",", $anos);
$desenhosFinal = implode(",", $desenhosFinal);

//$saida = sprintf('{"categorias":[%s], "series":[%s]}', $anos , $knowhows);
$saida = sprintf('{"series":[%s]}', $desenhosFinal);
echo $saida;
?>