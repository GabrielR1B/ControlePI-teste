<?php
class AreasConhecimentoController extends AppController {

	var $name = 'AreasConhecimento';
	var $uses = array('AreaConhecimento');
	
	function ajaxListar() {
		$this->autoRender = false;		
		$nome = $_GET['term'];
				
		$params = array(
			'fields'=>array('id','nome'),
			'order' => array('AreaConhecimento.nome ASC'),
			'conditions' => array('AreaConhecimento.nome LIKE' => '%'.$nome.'%'),
			'recursive' => 0
		);
		
		$areas = $this->AreaConhecimento->find('all', $params);

		$itens = array();
		foreach ($areas as $area) {
			$item = sprintf('{"id":"%d", "nome":"%s", "value":"%s"}', $area['AreaConhecimento']['id'], $area['AreaConhecimento']['nome'], $area['AreaConhecimento']['nome']);
			array_push($itens, $item);
		}

		echo '[' . implode(",", $itens) . ']';
	}
}