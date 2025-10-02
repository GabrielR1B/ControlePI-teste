<?php 
$anos = array();
$softwares = array();
$softwaresFinal = array();

foreach($resultado as $item) {
	array_push($anos, $item[0]['ano']);
	array_push($softwares, $item[0]['total']);
}

$thisYear = (int)date (Y);
$posSoftware = 0;
for ($i=1992; $i <= $thisYear; $i++) { 
	$istr = (string)$i;
	if (strcmp($anos[$posSoftware], $istr) == 0){
		array_push($softwaresFinal, $softwares[$posSoftware]);
		$posSoftware++;
	}
	else {
		array_push($softwaresFinal, '0');
	}
}

//$anos = implode(",", $anos);
$softwaresFinal = implode(",", $softwaresFinal);

//$saida = sprintf('{"categorias":[%s], "series":[%s]}', $anos , $softwares);
$saida = sprintf('{"series":[%s]}', $softwaresFinal);
echo $saida;
?>