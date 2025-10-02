<?php
class AreaConhecimento extends AppModel {
	var $name = 'AreaConhecimento';
	var $displayField = 'codigo_nome';
	var $useTable = 'areas_conhecimento';

	public $virtualFields = array(
    	'codigo_nome' => 'CONCAT(AreaConhecimento.nome, " - ", AreaConhecimento.numero)'
	);

	var $hasMany = array(
		'Tecnologia' => array(
			'className' => 'Tecnologia',
			'foreignKey' => 'area_conhecimento_id',
			'dependent' => false
		)
	);
}
?>
