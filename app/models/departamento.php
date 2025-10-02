<?php

class Departamento extends AppModel {
	var $name = 'Departamento';
	var $displayField = 'nome';
	
	var $hasAndBelongsToMany = array(
		'Tecnologia' => array(
			'className' => 'Tecnologia',
			'joinTable' => 'departamentos_tecnologias',
			'foreignKey' => 'departamento_id',
			'associationForeignKey' => 'tecnologia_id',
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
		'Knowhow' => array(
			'className' => 'Knowhow',
			'joinTable' => 'departamentos_knowhows',
			'foreignKey' => 'departamento_id',
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
			'foreignKey' => 'departamento_id',
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
			'foreignKey' => 'departamento_id',
			'associationForeignKey' => 'desenho_id',
			'unique' => true
		),
		'PatenteInternacional' => array(
			'className' => 'PatenteInternacional',
			'joinTable' => 'departamentos_patentes_internacionais',
			'foreignKey' => 'departamento_id',
			'associationForeignKey' => 'patente_internacional_id',
			'unique' => true
		)
	);

	var $belongsTo = array(
		'Unidade' => array(
			'className' => 'Unidade',
			'foreignKey' => 'unidade_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	
}

?>