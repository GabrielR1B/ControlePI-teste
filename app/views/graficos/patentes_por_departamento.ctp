<?php 

	$saida = array();
	$saida['dados'] = array();
	$outros = 0;

	foreach ($resultado as $departamento) {
		if($departamento[0]['total'] > 10){
			array_push($saida['dados'], 
				array(
					$departamento['departamentos']['nome'],
					intval($departamento[0]['total']),
					intval($departamento['departamentos']['id'])
				)
			);
		}else{
			$outros = $outros + $departamento[0]['total'];
		}
	}

	array_push($saida['dados'], 
		array(
			"Outros",
			$outros,
			0)
	);

	echo json_encode($saida);
?>