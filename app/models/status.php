<?php
class Status extends AppModel {
	var $name = 'Status';
	var $displayField = 'nome';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Tecnologia' => array(
			'className' => 'Tecnologia',
			'foreignKey' => 'status_id',
			'dependent' => false
		),
		'Software' => array(
			'className' => 'Software',
			'foreignKey' => 'status_id',
			'dependent' => false
		),
		'Desenho' => array(
			'className' => 'Desenho',
			'foreignKey' => 'status_id',
			'dependent' => false
		),
		'Marcas' => array(
			'className' => 'Marca',
			'foreignKey' => 'status_id',
			'dependent' => false
		)
	);

}
?>
