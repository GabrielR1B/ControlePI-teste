<?php 

	$resultado = array();

	foreach ($palavrasChave as $palavraChave) {
		array_push($resultado, $palavraChave['Palavrachave']);
	}

	echo json_encode($resultado);

?>