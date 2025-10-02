<?php
class Tecnologia extends AppModel {
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
		'num_pedido' => null,
		'data' => null,
		'pasta' => null,
		'natureza_id' => null,
		'area_id' => null,
		'status_id' => null,
		'andamento_id' => null,
		'redator_id' => null,
		'pais_id' => null,
	);
	function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->validate['titulo'] = $this->requiredField('Título');
		$this->validate['num_pedido'] = $this->requiredField('Número do Pedido');
		$this->validate['pasta'] = $this->requiredField('Pasta');
	}

	var $name = 'Tecnologia';
	var $displayField = 'titulo';
	

	var $hasMany = array(
		'Arquivo' => array(
			'className' => 'Arquivo',
			'foreignKey' => 'tecnologia_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'InventoresTecnologia',
		'Publicacao' => array(
			'className' => 'Publicacao',
			'foreignKey' => 'tecnologia_id',
			'dependent' => true
		)
	);

	var $belongsTo = array(
		'NaturezaTecnologia' => array(
			'className' => 'NaturezaTecnologia',
			'foreignKey' => 'natureza_id',
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
		),
		'Andamento' => array(
			'className' => 'Andamento',
			'foreignKey' => 'andamento_id',
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
		),
		'Pais' => array(
			'className' => 'Pais',
			'foreignKey' => 'pais_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'PrioridadeInterna' => array(
            'className' => 'Tecnologia',
            'foreignKey' => 'prioridade_interna_id',
            'conditions' => ''
        )
	);

	var $hasAndBelongsToMany = array(
		'Inventor' => array(
			'className' => 'Inventor',
			'joinTable' => 'inventores_tecnologias',
			'foreignKey' => 'tecnologia_id',
			'associationForeignKey' => 'inventor_id',
			'unique' => true
		),
		'Palavrachave' => array(
			'className' => 'Palavrachave',
			'joinTable' => 'palavraschave_tecnologias',
			'foreignKey' => 'tecnologia_id',
			'associationForeignKey' => 'palavrachave_id',
			'unique' => true
		),
		'Titular' => array(
			'className' => 'Titular',
			'joinTable' => 'tecnologias_titulares',
			'foreignKey' => 'tecnologia_id',
			'associationForeignKey' => 'titular_id',
			'unique' => true
		),
		'Departamento' => array(
			'className' => 'Departamento',
			'joinTable' => 'departamentos_tecnologias',
			'foreignKey' => 'tecnologia_id',
			'associationForeignKey' => 'departamento_id',
			'unique' => true
		),
		'Unidade' => array(
			'className' => 'Unidade',
			'joinTable' => 'departamentos_tecnologias',
			'foreignKey' => 'tecnologia_id',
			'associationForeignKey' => 'unidade_id',
			'unique' => true
		),
		'Departamento' => array(
			'className' => 'Departamento',
			'joinTable' => 'departamentos_tecnologias',
			'foreignKey' => 'tecnologia_id',
			'associationForeignKey' => 'departamento_id',
			'unique' => true
		),
		'PatenteInternacional' => array(
			'className' => 'PatenteInternacional',
			'joinTable' => 'patentes_internacionais_tecnologias',
			'foreignKey' => 'tecnologia_id',
			'associationForeignKey' => 'patente_internacional_id',
			'unique' => true
		),
		'Empresa' => array(
			'className' => 'Empresa',
			'joinTable' => 'empresas_tecnologias',
			'foreignKey' => 'pi_id',
			'associationForeignKey' => 'empresa_id',
			'unique' => true,
			'conditions' => array('EmpresasTecnologia.natureza_pi_id' => '1')
		),
		'AreaConhecimento' => array(
			'className' => 'AreaConhecimento',
			'joinTable' => 'areas_conhecimento_tecnologias',
			'foreignKey' => 'tecnologia_id',
			'associationForeignKey' => 'area_conhecimento_id',
			'unique' => true
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
		$colunas['status_transferencia_id'] = array('field'=>'status_transferencia_id','label'=>'Status da Transferência','checked'=>true,'width'=>20);
		$colunas['observacoes_transferencia'] = array('field'=>'observacoes_transferencia','label'=>'Observações da Transferência','checked'=>true,'width'=>20);
		$colunas['observacoes'] = array('field'=>'observacoes','label'=>'Observações','checked'=>true,'width'=>20);
		$colunas['pct'] = array('field'=>'pct','label'=>'PCT','checked'=>true);
		$colunas['resumo'] = array('field'=>'resumo','label'=>'Resumo','checked'=>true,'width'=>50);
		$colunas['reivindicacoes'] = array('field'=>'reivindicacoes','label'=>'Reivindicacoes','checked'=>true);
		$colunas['tem_sisgen'] = array('field'=>'tem_sisgen','label'=>'Possui registro no SisGen','checked'=>true);
		$colunas['num_sisgen'] = array('field'=>'num_sisgen','label'=>'Número do SisGen','checked'=>true);
		$colunas['ultimo_despacho'] = array('field'=>'ultimo_despacho','label'=>'Último Despacho','checked'=>true);
		$colunas['inventores'] = array('field'=>'inventores','label'=>'Inventores','checked'=>true);
		$colunas['titulares'] = array('field'=>'titulares','label'=>'Titulares','checked'=>true);
		
		return $colunas;
	}
}
?>