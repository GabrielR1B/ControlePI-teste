<?php 
$itens = array();
foreach ($inventores as $k => $v) {
	$item = sprintf('{"id":"%d", "nome":"%s", "value":"%s"}', $k, $v, $v);
	array_push($itens, $item);
}

$saida = '[' . implode(",", $itens) . ']';

echo $saida;
?>