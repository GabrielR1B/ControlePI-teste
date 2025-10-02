<?php
class Apresentacao extends AppModel {
	var $name = 'Apresentacao';
	var $displayField = 'apresentacao';
	
	var $validate = array(
		'apresentacao' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		)
	);

	var $hasMany = array(
		'Marca' => array(
			'className' => 'Marca',
			'foreignKey' => 'apresentacao_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
}
?>