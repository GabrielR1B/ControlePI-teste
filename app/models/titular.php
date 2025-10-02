<?php
class Titular extends AppModel {
	var $name = 'Titular';
	var $displayField = 'nome';
	
	var $validate = array(
		'nome' => array(
            'rule' => 'notEmpty'
        ),
		'cnpj' => array(
            'rule' => 'notEmpty'
        )
	);

	var $hasAndBelongsToMany = array(
		'Tecnologia' => array(
			'className' => 'Tecnologia',
			'joinTable' => 'tecnologias_titulares',
			'foreignKey' => 'titular_id',
			'associationForeignKey' => 'tecnologia_id',
			'unique' => true
		),
		'Software' => array(
			'className' => 'Software',
			'joinTable' => 'softwares_titulares',
			'foreignKey' => 'titular_id',
			'associationForeignKey' => 'software_id',
			'unique' => true
		),
		'Desenho' => array(
			'className' => 'Desenho',
			'joinTable' => 'desenhos_titulares',
			'foreignKey' => 'titular_id',
			'associationForeignKey' => 'desenho_id',
			'unique' => true
		),
		'Marca' => array(
			'className' => 'Marca',
			'joinTable' => 'marcas_titulares',
			'foreignKey' => 'titular_id',
			'associationForeignKey' => 'marca_id',
			'unique' => true
		)
	);
}
?>