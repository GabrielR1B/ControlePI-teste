<?php

class Unidade extends AppModel {
	var $name = 'Unidade';
	var $displayField = 'nome';
	
	var $hasAndBelongsToMany = array(
		'Tecnologia' => array(
			'className' => 'Tecnologia',
			'joinTable' => 'departamentos_tecnologias',
			'foreignKey' => 'unidade_id',
			'associationForeignKey' => 'tecnologia_id',
			'unique' => true
		),
		'Knowhow' => array(
			'className' => 'Knowhow',
			'joinTable' => 'departamentos_knowhows',
			'foreignKey' => 'unidade_id',
			'associationForeignKey' => 'knowhow_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Software' => array(
			'className' => 'Software',
			'joinTable' => 'departamentos_softwares',
			'foreignKey' => 'unidade_id',
			'associationForeignKey' => 'software_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Desenho' => array(
			'className' => 'Desenho',
			'joinTable' => 'departamentos_desenhos',
			'foreignKey' => 'unidade_id',
			'associationForeignKey' => 'desenho_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

	var $hasMany = array(
		'Departamento' => array(
			'className' => 'Departamento',
			'foreignKey' => 'unidade_id',
			'dependent' => false,
		)
	);
	
}

?>