<?php 
	$anos = array();
	$patentes = array();
	$patentesFinal = array();
	$patentesPorAno = array();
	
	$thisYear = (int)date (Y);
	foreach($resultado as $item) {
		$patentesPorAno[$item[0]['ano']] = $item[0]['total'];
	}

	for ($i=1992; $i <= $thisYear; $i++) {
		if(!array_key_exists($i, $patentesPorAno))
		{
			$patentesPorAno[$i] = 0;
		}
	}

	ksort($patentesPorAno);


	printf('{"categorias":[%s],"series":[%s]}', implode(",", array_keys($patentesPorAno)), implode(",", array_values($patentesPorAno)));
?>