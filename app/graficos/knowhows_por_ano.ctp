<?php 

$anos = array();
$knowhows = array();
$knowhowsFinal = array();

foreach($resultado as $item) {
	array_push($anos, $item[0]['ano']);
	array_push($knowhows, $item[0]['total']);
}

$thisYear = (int)date (Y);
$posKnowhow = 0;
for ($i=1992; $i <= $thisYear; $i++) { 
	$istr = (string)$i;
	if (strcmp($anos[$posKnowhow], $istr) == 0){
		array_push($knowhowsFinal, $knowhows[$posKnowhow]);
		$posKnowhow++;
	}
	else {
		array_push($knowhowsFinal, '0');
	}
}

//$anos = implode(",", $anos);
$knowhowsFinal = implode(",", $knowhowsFinal);

//$saida = sprintf('{"categorias":[%s], "series":[%s]}', $anos , $knowhows);
$saida = sprintf('{"series":[%s]}', $knowhowsFinal);
echo $saida;
?>