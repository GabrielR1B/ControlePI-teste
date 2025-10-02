<?php
class Pais extends AppModel {
	var $name = 'Pais';
	var $displayField = 'nome';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Tecnologia' => array(
			'className' => 'Tecnologia',
			'foreignKey' => 'pais_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'PatenteInternacional' => array(
			'className' => 'PatenteInternacional',
			'foreignKey' => 'pais_id',
			'dependent' => false,
		)
	);

}
?>