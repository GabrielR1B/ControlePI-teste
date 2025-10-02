<?php
class Escritorio extends AppModel {
	var $name = 'Escritorio';
	var $displayField = 'nome';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'PatenteInternacional' => array(
			'className' => 'PatenteInternacional',
			'foreignKey' => 'escritorio_id',
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
