<?php 
// print_r($inventores);exit;
// echo json_encode($inventores); 
// [ { "id": "Nycticorax nycticorax", "label": "Black-crowned Night Heron", "value": "Black-crowned Night Heron" },

$itens = array();

//var_dump($departamentos); exit;
foreach ($departamentos as $departamento) {
	$item = sprintf('{"id":"%d", "nome":"%s", "unidadeId":"%s","value":"%s / %s"}', $departamento['Departamento']['id'], $departamento['Departamento']['nome'], $departamento['Unidade']['id'], $departamento['Unidade']['nome'], $departamento['Departamento']['nome']);
	array_push($itens, $item);
}

$saida = '[' . implode(",", $itens) . ']';

echo $saida;

?>