<?php 
// print_r($inventores);exit;
// echo json_encode($inventores); 
// [ { "id": "Nycticorax nycticorax", "label": "Black-crowned Night Heron", "value": "Black-crowned Night Heron" },

$itens = array();
foreach ($inventores as $k => $v) {
	$item = sprintf('{"id":"%d", "nome":"%s", "value":"%s"}', $k, $v, $v);
	array_push($itens, $item);
}

$saida = '[' . implode(",", $itens) . ']';

echo $saida;



?>