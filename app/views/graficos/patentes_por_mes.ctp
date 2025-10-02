<?php 
	function verifica_mes($resultado,$mes,$ano){
		foreach ($resultado as $item) {
			if($item[0]['ano'] == $ano){
				if($item[0]['mes'] == $mes){
					return intval($item[0]['total']);
				}
			}
		}
		return intval (0);
		//var_dump($resultado);
	}

	//var_dump(verifica_mes($resultado,8,1996));

	$meses = array();
	$patentes = array();
	$medias[13];
	$nAnos=3;

	for($a=2012-$nAnos;$a<=2012;$a++){
		for($m=1;$m<=12;$m++){
			//echo $m."/".$a."<br>";
			$verifica = verifica_mes($resultado,$m,$a);
			//echo $m."/".$a."  ".$verifica."<br>";
			
			if($verifica == 0){
				array_push($meses, '"'.$m."/".$a.'"');
				array_push($patentes, 0);
				$medias[$m]=$medias[$m]+0;
			}else{
				array_push($meses, '"'.$m."/".$a.'"');
				array_push($patentes, $verifica);
				$medias[$m]=$medias[$m]+$verifica;
			}
			
			//$verifica = 0;
			
			//echo "<br>";
			/*if(verifica_mes($resultado,$mes,$ano)){
				echo $mes."/".$ano."<br>";
			}*/
		}
	}


	//print_r($meses);
	
	/*foreach($resultado as $item) {
		array_push($meses, '"'.$item[0]['mes']."/".$item[0]['ano'].'"');
		array_push($patentes, $item[0]['total']);
	}*/

	number_format($number, 2, ',', ' ');
	
	for($i=1;$i<13;$i++){
		$medias[$i]=number_format($medias[$i]/$nAnos, 2);
	}
	
	$meses = implode(",", $meses);
	$patentes = implode(",", $patentes);
	$medias = implode(",", $medias);
	
	$saida = sprintf('{"categorias":[%s], "series":[%s], "medias":[%s]}', $meses , $patentes, $medias);
	echo $saida;
?>