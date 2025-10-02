<?php 

	$anos = array();
	$patentes = array();

	foreach($resultado as $item) {
		array_push($anos, intval($item[0]['ano']));
		array_push($patentes, intval($item[0]['total']));
	}

	$resultado = array();

	$resultado['categorias'] = $anos;
	$resultado['series'] = $patentes;

	echo json_encode($resultado);


?>