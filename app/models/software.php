<?php
class Software extends AppModel {
	/**
	 * Gera regra de validação obrigatória padronizada
	 */
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
		'titular' => null,
		'funcionalidade' => null,
		'inventores' => null,
		'pasta' => null,
	);

	function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->validate['titulo'] = $this->requiredField('Título');
		$this->validate['titular'] = $this->requiredField('Titular');
		$this->validate['funcionalidade'] = $this->requiredField('Funcionalidade');
		$this->validate['inventores'] = $this->requiredField('Inventores');
		$this->validate['pasta'] = $this->requiredField('Pasta');
	}
	var $name = 'Software';
	var $displayField = 'titulo';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Status' => array(
			'className' => 'Status',
			'foreignKey' => 'status_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasAndBelongsToMany = array(
		'Departamento' => array(
			'className' => 'Departamento',
			'joinTable' => 'departamentos_softwares',
			'foreignKey' => 'software_id',
			'associationForeignKey' => 'departamento_id',
			'unique' => true
		),
		'Unidade' => array(
			'className' => 'Unidade',
			'joinTable' => 'departamentos_softwares',
			'foreignKey' => 'software_id',
			'associationForeignKey' => 'unidade_id',
			'unique' => true
		),
		'Inventor' => array(
			'className' => 'Inventor',
			'joinTable' => 'inventores_softwares',
			'foreignKey' => 'software_id',
			'associationForeignKey' => 'inventor_id',
			'unique' => true
		),
		'Titular' => array(
			'className' => 'Titular',
			'joinTable' => 'softwares_titulares',
			'foreignKey' => 'software_id',
			'associationForeignKey' => 'titular_id',
			'unique' => true
		),
		'Empresa' => array(
			'className' => 'Empresa',
			'joinTable' => 'empresas_tecnologias',
			'foreignKey' => 'pi_id',
			'associationForeignKey' => 'empresa_id',
			'unique' => true,
			'conditions' => array('EmpresasTecnologia.natureza_pi_id' => '5')
		)
	);

	var $hasMany = array(
		'Arquivo' => array(
			'className' => 'Arquivo',
			'foreignKey' => 'software_id',
			'dependent' => true
		)
	);
}
