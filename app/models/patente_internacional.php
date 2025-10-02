<?php
class PatenteInternacional extends AppModel {
	var $name = 'PatenteInternacional';
	var $displayField = 'titulo';
	var $useTable = "patentes_internacionais";

	/*
	var $validate = array(
		'titulo' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'num_pedido' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	);*/

	var $hasMany = array(
		'Arquivo' => array(
			'className' => 'Arquivo',
			'foreignKey' => 'patente_internacional_id',
			'dependent' => true
		)
	);

	var $belongsTo = array(
		'Area' => array(
			'className' => 'Area',
			'foreignKey' => 'area_id'
		),
		'StatusInternacional' => array(
			'className' => 'StatusInternacional',
			'foreignKey' => 'status_id'
		),
		'StatusTransferencia' => array(
			'className' => 'StatusTransferencia',
			'foreignKey' => 'status_transferencia_id'
		),
		'Pais' => array(
			'className' => 'Pais',
			'foreignKey' => 'pais_id'
		),
		'Escritorio' => array(
			'className' => 'Escritorio',
			'foreignKey' => 'escritorio_id'
		),
		'NaturezaPatenteInternacional' => array(
			'className' => 'NaturezaPatenteInternacional',
			'foreignKey' => 'natureza_id'
		),
		'Pais' => array(
			'className' => 'Pais',
			'foreignKey' => 'pais_id'
		),
		'Redator' => array(
			'className' => 'Redator',
			'foreignKey' => 'redator_id'
		)
	);

	var $hasAndBelongsToMany = array(
		'Tecnologia' => array(
			'className' => 'Tecnologia',
			'joinTable' => 'patentes_internacionais_tecnologias',
			'foreignKey' => 'patente_internacional_id',
			'associationForeignKey' => 'tecnologia_id',
			'unique' => true
		),
		'Titular' => array(
			'className' => 'Titular',
			'joinTable' => 'patentes_internacionais_titulares',
			'foreignKey' => 'patente_internacional_id',
			'associationForeignKey' => 'titular_id',
			'unique' => true
		),
		'Inventor' => array(
			'className' => 'Inventor',
			'joinTable' => 'inventores_patentes_internacionais',
			'foreignKey' => 'patente_internacional_id',
			'associationForeignKey' => 'inventor_id',
			'unique' => true
		),
		'Departamento' => array(
			'className' => 'Departamento',
			'joinTable' => 'departamentos_patentes_internacionais',
			'foreignKey' => 'patente_internacional_id',
			'associationForeignKey' => 'departamento_id',
			'unique' => true
		),
		'Unidade' => array(
			'className' => 'Unidade',
			'joinTable' => 'departamentos_patentes_internacionais',
			'foreignKey' => 'patente_internacional_id',
			'associationForeignKey' => 'unidade_id',
			'unique' => true
		),
		'Empresa' => array(
			'className' => 'Empresa',
			'joinTable' => 'empresas_tecnologias',
			'foreignKey' => 'pi_id',
			'associationForeignKey' => 'empresa_id',
			'unique' => true,
			'conditions' => array('EmpresasTecnologia.natureza_pi_id' => '2')
		)
	);

	public function intersection($array1,$array2)
	{
		$resultado = array();
		foreach ($array1['PatenteInternacional'] as $patente1) {
			foreach ($array2 as $patente2) {
				if($array1['PatenteInternacional']['id']==$patente2['id']){
					array_push($resultado, $array1['PatenteInternacional']);
				}
			}
		}
	}

	function CamposExportacao(){
		$colunas = [];
		$colunas['id'] = array('field'=>'id','label'=>'Id','checked'=>true);
		$colunas['pasta'] = array('field'=>'pasta','label'=>'Pasta','checked'=>true,'width'=>10);
		$colunas['pasta_juridico'] = array('field'=>'pasta_juridico','label'=>'Pasta Jurídico','checked'=>true,'width'=>10);
		$colunas['data'] = array('field'=>'data','label'=>'Data','checked'=>true,'width'=>12);
		$colunas['natureza_id'] = array('field'=>'natureza_id','label'=>'Natureza','checked'=>true,'width'=>12);
		$colunas['area_id'] = array('field'=>'area_id','label'=>'Área','checked'=>true,'width'=>12);
		$colunas['data_internacional'] = array('field'=>'data_internacional','label'=>'Data Internacional','checked'=>true,'width'=>12);
		$colunas['pais_id'] = array('field'=>'pais_id','label'=>'País','checked'=>true,'width'=>12);
		$colunas['titulo'] = array('field'=>'titulo','label'=>'Título','checked'=>true,'width'=>50);
		$colunas['num_pct'] = array('field'=>'num_pct','label'=>'Número PCT','checked'=>true,'width'=>12);
		$colunas['num_publicacao'] = array('field'=>'num_publicacao','label'=>'Número da Publicação','checked'=>true,'width'=>12);
		$colunas['num_pedido'] = array('field'=>'num_pedido','label'=>'Número do Pedido','checked'=>true,'width'=>20);
		$colunas['escritorio_id'] = array('field'=>'escritorio_id','label'=>'Escritório','checked'=>true,'width'=>12);
		$colunas['data_concessao'] = array('field'=>'data_concessao','label'=>'Data Concessão','checked'=>true,'width'=>12);
		$colunas['status_id'] = array('field'=>'status_id','label'=>'Status','checked'=>true,'width'=>20);
		$colunas['status_transferencia_id'] = array('field'=>'status_transferencia_id','label'=>'Status da Transferência','checked'=>true,'width'=>20);	
		$colunas['observacoes_status_transferencia'] = array('field'=>'observacoes_status_transferencia','label'=>'Observações da Transferência','checked'=>true,'width'=>20);
		$colunas['numero_pasta_setor_regularizacao'] = array('field'=>'numero_pasta_setor_regularizacao','label'=>'Número da Pasta no Setor de Regularização de PI','checked'=>true,'width'=>20);
		$colunas['num_processo_sei'] = array('field'=>'num_processo_sei','label'=>'Número do Processo SEI','checked'=>true,'width'=>20);
		$colunas['observacoes'] = array('field'=>'observacoes','label'=>'Observações','checked'=>true,'width'=>20);
		$colunas['contrato_cotitularidade'] = array('field'=>'contrato_cotitularidade','label'=>'Contrato de Cotitularidade','checked'=>true);
		$colunas['justificativa_cotitularidade'] = array('field'=>'justificativa_cotitularidade','label'=>'Justificativa da Cotitularidade','checked'=>true);
		
		return $colunas;
	}
}
?>