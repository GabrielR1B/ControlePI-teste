<?php 
$itens = array();
foreach ($palavraschave as $k => $v) {
	$item = sprintf('{"id":"%d", "palavra":"%s", "value":"%s"}', $k, $v, $v);
	array_push($itens, $item);
}

$saida = '[' . implode(",", $itens) . ']';

echo $saida;

?>