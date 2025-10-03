<?php
class Knowhow extends AppModel {

	private function requiredField($fieldLabel) {
		return array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => "O campo $fieldLabel é obrigatório.",
				'allowEmpty' => false,
				'required' => true,
			),
		);
	}
	var $validate = array(
		'titulo' => null,
		'pasta' => null,
	);
	function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->validate['titulo'] = $this->requiredField('Título');
		$this->validate['pasta'] = $this->requiredField('Pasta');
	}

	var $name = 'Knowhow';
	var $displayField = 'titulo';

	var $hasAndBelongsToMany = array(
		'Departamento' => array(
			'className' => 'Departamento',
			'joinTable' => 'departamentos_knowhows',
			'foreignKey' => 'knowhow_id',
			'associationForeignKey' => 'departamento_id',
			'unique' => true,
			'conditions' => ''
		),
		'Unidade' => array(
			'className' => 'Unidade',
			'joinTable' => 'departamentos_knowhows',
			'foreignKey' => 'knowhow_id',
			'associationForeignKey' => 'unidade_id',
			'unique' => true,
			'conditions' => ''
		),
		'Inventor' => array(
			'className' => 'Inventor',
			'joinTable' => 'inventores_knowhows',
			'foreignKey' => 'knowhow_id',
			'associationForeignKey' => 'inventor_id',
			'unique' => true,
			'conditions' => ''
		),
		'Empresa' => array(
			'className' => 'Empresa',
			'joinTable' => 'empresas_tecnologias',
			'foreignKey' => 'pi_id',
			'associationForeignKey' => 'empresa_id',
			'unique' => true,
			'conditions' => array('EmpresasTecnologia.natureza_pi_id' => '6')
		)
	);

	var $belongsTo = array(
		'Titular' => array(
			'className' => 'Titular',
			'foreignKey' => 'titular_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Area' => array(
			'className' => 'Area',
			'foreignKey' => 'area_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Status' => array(
			'className' => 'Status',
			'foreignKey' => 'status_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Arquivo' => array(
			'className' => 'Arquivo',
			'foreignKey' => 'knowhow_id',
			'dependent' => true
		)
	);

}
