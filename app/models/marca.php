<?php
class Marca extends AppModel {

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
		'processo' => null,
		'pasta' => null,
	);
	function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->validate['titulo'] = $this->requiredField('Título');
		$this->validate['processo'] = $this->requiredField('Número do Processo');
		$this->validate['pasta'] = $this->requiredField('Pasta');
	}
	var $name = 'Marca';
	var $displayField = 'nome';

	var $belongsTo = array(
		'NaturezaMarca' => array(
			'className' => 'NaturezaMarca',
			'foreignKey' => 'naturezamarca_id'
		),
		'Apresentacao' => array(
			'className' => 'Apresentacao',
			'foreignKey' => 'apresentacao_id'
		),	
		'Andamento' => array(
			'className' => 'Andamento',
			'foreignKey' => 'andamento_id'
		),	
		'Status' => array(
			'className' => 'Status',
			'foreignKey' => 'status_id'
		)
	);

	var $hasAndBelongsToMany = array(
		'Inventor' => array(
			'className' => 'Inventor',
			'joinTable' => 'inventores_marcas',
			'foreignKey' => 'marca_id',
			'associationForeignKey' => 'inventor_id',
			'unique' => true
		),
		'Titular' => array(
			'className' => 'Titular',
			'joinTable' => 'marcas_titulares',
			'foreignKey' => 'marca_id',
			'associationForeignKey' => 'titular_id',
			'unique' => true
		),
		'Empresa' => array(
			'className' => 'Empresa',
			'joinTable' => 'empresas_tecnologias',
			'foreignKey' => 'pi_id',
			'associationForeignKey' => 'empresa_id',
			'unique' => true,
			'conditions' => array('EmpresasTecnologia.natureza_pi_id' => '4')
		)
	);

	var $hasMany = array(
		'Arquivo' => array(
			'className' => 'Arquivo',
			'foreignKey' => 'marca_id',
			'dependent' => true
		)
	);

	function CamposExportacao(){
		$colunas = [];
		$colunas['id'] = array('field'=>'id','label'=>'Id','checked'=>true);
		$colunas['nome'] = array('field'=>'nome','label'=>'Nome','checked'=>true,'width'=>50);
		$colunas['processo'] = array('field'=>'processo','label'=>'Processo','checked'=>true,'width'=>20);
		$colunas['naturezamarca_id'] = array('field'=>'naturezamarca_id','label'=>'Natureza','checked'=>true,'width'=>12);
		$colunas['apresentacao_id'] = array('field'=>'apresentacao_id','label'=>'Apresentação','checked'=>true,'width'=>12);
		$colunas['data'] = array('field'=>'data','label'=>'Data','checked'=>true,'width'=>12);
		$colunas['classe'] = array('field'=>'classe','label'=>'Classe','checked'=>true,'width'=>12);
		$colunas['pasta'] = array('field'=>'pasta','label'=>'Pasta','checked'=>true,'width'=>10);
		$colunas['pasta_juridico'] = array('field'=>'pasta_juridico','label'=>'Pasta Jurídico','checked'=>true,'width'=>10);
		$colunas['andamento_id'] = array('field'=>'andamento_id','label'=>'Andamento','checked'=>true,'width'=>12);
		$colunas['status_id'] = array('field'=>'status_id','label'=>'Status','checked'=>true,'width'=>12);
		$colunas['observacoes'] = array('field'=>'observacoes','label'=>'Observações','checked'=>true,'width'=>20);
		$colunas['titulares'] = array('field'=>'titulares','label'=>'Titulares','checked'=>true);
		
		return $colunas;
	}
}
?>