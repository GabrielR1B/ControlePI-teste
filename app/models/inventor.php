<?php
class Inventor extends AppModel {
	var $name = 'Inventor';
	var $displayField = 'nome';

	var $hasAndBelongsToMany = array(
		'Tecnologia' => array(
			'className' => 'Tecnologia',
			'joinTable' => 'inventores_tecnologias',
			'foreignKey' => 'inventor_id',
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
			'joinTable' => 'inventores_knowhows',
			'foreignKey' => 'inventor_id',
			'associationForeignKey' => 'knowhow_id',
			'unique' => true
		),
		'Software' => array(
			'className' => 'Software',
			'joinTable' => 'inventores_softwares',
			'foreignKey' => 'inventor_id',
			'associationForeignKey' => 'software_id',
			'unique' => true
		),
		'Desenho' => array(
			'className' => 'Desenho',
			'joinTable' => 'desenhos_inventores',
			'foreignKey' => 'inventor_id',
			'associationForeignKey' => 'desenho_id',
			'unique' => true
		),
		'PatenteInternacional' => array(
			'className' => 'PatenteInternacional',
			'joinTable' => 'inventores_patentes_internacionais',
			'foreignKey' => 'inventor_id',
			'associationForeignKey' => 'patente_internacional_id',
			'unique' => true
		)
	);

	var $hasMany = array(
		'InventoresTecnologia'
	);

	/*var $belongsTo = array(
		'Titulo' => array(
			'className' => 'Titulo',
			'foreignKey' => 'titulo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Categoria' => array(
			'className' => 'Categoria',
			'foreignKey' => 'categoria_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);*/

}
?>