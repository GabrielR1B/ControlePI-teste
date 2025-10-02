<?php 
$areas = array();
$tecnologias = array();

$saida = array();
$outros=0;
foreach($resultado as $item) {
	if($item[0]['total']>=10){
		$elemento = sprintf('["%s", %s, %s]', $item['a']['nome'], $item[0]['total'], $item['a']['id']);
		array_push($saida, $elemento);
	}else{
		$outros=$outros+$item[0]['total'];
	}
}
$elemento = sprintf('["%s", %s]', "Outros", $outros);
array_push($saida, $elemento);

$saida = implode(",", $saida);
$saida = sprintf('{"dados":[%s]}', $saida);
echo $saida;
?>