<?php 
$areas = array();
$tecnologias = array();

$saida = array();
foreach($resultado as $item) {
	$elemento = sprintf('["%s", %s]', $item['a']['area'], $item[0]['total']);
	array_push($saida, $elemento);
}


$saida = implode(",", $saida);
$saida = sprintf('{"dados":[%s]}', $saida);
echo $saida;
?>