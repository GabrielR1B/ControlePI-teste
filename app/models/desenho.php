<?php
class Desenho extends AppModel {
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
		'num_pedido' => null,
		'pasta' => null,
	);
	function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->validate['titulo'] = $this->requiredField('Título');
		$this->validate['num_pedido'] = $this->requiredField('Número do Pedido');
		$this->validate['pasta'] = $this->requiredField('Pasta');
	}

	var $name = 'Desenho';
	var $displayField = 'titulo';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Area' => array(
			'className' => 'Area',
			'foreignKey' => 'area_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Andamento' => array(
			'className' => 'Andamento',
			'foreignKey' => 'andamento_id',
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
		),
		'Redator' => array(
			'className' => 'Redator',
			'foreignKey' => 'redator_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasAndBelongsToMany = array(
		'Departamento' => array(
			'className' => 'Departamento',
			'joinTable' => 'departamentos_desenhos',
			'foreignKey' => 'desenho_id',
			'associationForeignKey' => 'departamento_id',
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
		'Inventor' => array(
			'className' => 'Inventor',
			'joinTable' => 'desenhos_inventores',
			'foreignKey' => 'desenho_id',
			'associationForeignKey' => 'inventor_id',
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
		'Titular' => array(
			'className' => 'Titular',
			'joinTable' => 'desenhos_titulares',
			'foreignKey' => 'desenho_id',
			'associationForeignKey' => 'titular_id',
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
		'Unidade' => array(
			'className' => 'Unidade',
			'joinTable' => 'departamentos_desenhos',
			'foreignKey' => 'desenho_id',
			'associationForeignKey' => 'unidade_id',
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
		'Empresa' => array(
			'className' => 'Empresa',
			'joinTable' => 'empresas_tecnologias',
			'foreignKey' => 'pi_id',
			'associationForeignKey' => 'empresa_id',
			'unique' => true,
			'conditions' => array('EmpresasTecnologia.natureza_pi_id' => '3')
		)
	);

	var $hasMany = array(
		'Arquivo' => array(
			'className' => 'Arquivo',
			'foreignKey' => 'desenho_id',
			'dependent' => true
		)
	);

	function CamposExportacao(){
		$colunas = [];
		$colunas['id'] = array('field'=>'id','label'=>'Id','checked'=>true);
		$colunas['titulo'] = array('field'=>'titulo','label'=>'Título','checked'=>true,'width'=>50);
		$colunas['num_pedido'] = array('field'=>'num_pedido','label'=>'Número do Pedido','checked'=>true,'width'=>20);
		$colunas['data'] = array('field'=>'data','label'=>'Data','checked'=>true,'width'=>12);
		$colunas['pasta'] = array('field'=>'pasta','label'=>'Pasta','checked'=>true,'width'=>10);
		$colunas['andamento_id'] = array('field'=>'andamento_id','label'=>'Andamento','checked'=>true,'width'=>12);
		$colunas['observacoes'] = array('field'=>'observacoes','label'=>'Observações','checked'=>true,'width'=>20);
		$colunas['resumo'] = array('field'=>'resumo','label'=>'Resumo','checked'=>true,'width'=>50);
		$colunas['inventores'] = array('field'=>'inventores','label'=>'Inventores','checked'=>true);
		$colunas['titulares'] = array('field'=>'titulares','label'=>'Titulares','checked'=>true);
		
		return $colunas;
	}
}
