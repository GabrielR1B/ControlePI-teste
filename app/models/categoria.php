<?php
class Categoria extends AppModel {
	var $name = 'Categoria';
	var $displayField = 'nome';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'Inventor' => array(
			'className' => 'Inventor',
			'foreignKey' => 'categoria_id',
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