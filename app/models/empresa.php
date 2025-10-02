<?php
class Empresa extends AppModel {
	var $name = 'Empresa';
	var $displayField = 'nome';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/*var $hasMany = array(
		'Tecnologia' => array(
			'className' => 'Tecnologia',
			'foreignKey' => 'andamento_id',
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
		'Desenho' => array(
			'className' => 'Desenho',
			'foreignKey' => 'andamento_id',
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
	);*/

	var $hasAndBelongsToMany = array(
		'Tecnologia' => array(
			'className' => 'Tecnologia',
			'joinTable' => 'empresas_tecnologias',
			'foreignKey' => 'empresa_id',
			'associationForeignKey' => 'pi_id',
			'unique' => true,
			'conditions' => array('EmpresasTecnologia.natureza_pi_id' => '1')
		),
		'PatenteInternacional' => array(
			'className' => 'PatenteInternacional',
			'joinTable' => 'empresas_tecnologias',
			'foreignKey' => 'empresa_id',
			'associationForeignKey' => 'pi_id',
			'unique' => true,
			'conditions' => array('EmpresasTecnologia.natureza_pi_id' => '2')
		),
		'Desenho' => array(
			'className' => 'Desenho',
			'joinTable' => 'empresas_tecnologias',
			'foreignKey' => 'empresa_id',
			'associationForeignKey' => 'pi_id',
			'unique' => true,
			'conditions' => array('EmpresasTecnologia.natureza_pi_id' => '3')
		),
		'Marca' => array(
			'className' => 'Marca',
			'joinTable' => 'empresas_tecnologias',
			'foreignKey' => 'empresa_id',
			'associationForeignKey' => 'pi_id',
			'unique' => true,
			'conditions' => array('EmpresasTecnologia.natureza_pi_id' => '4')
		),
		'Software' => array(
			'className' => 'Software',
			'joinTable' => 'empresas_tecnologias',
			'foreignKey' => 'empresa_id',
			'associationForeignKey' => 'pi_id',
			'unique' => true,
			'conditions' => array('EmpresasTecnologia.natureza_pi_id' => '5')
		),
		'Knowhow' => array(
			'className' => 'Knowhow',
			'joinTable' => 'empresas_tecnologias',
			'foreignKey' => 'empresa_id',
			'associationForeignKey' => 'pi_id',
			'unique' => true,
			'conditions' => array('EmpresasTecnologia.natureza_pi_id' => '6')
		)
	);
}
?>
