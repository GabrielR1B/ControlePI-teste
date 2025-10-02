<?php
class Publicacao extends AppModel {
	public $name = 'Publicacao';
	public $primaryKey = 'id';
	public $displayField = 'titulo';

	var $belongsTo = array(
		'Tecnologia' => array(
			'className' => 'Tecnologia',
			'foreignKey' => 'tecnologia_id'
		),
		'Rpi' => array(
			'className' => 'Rpi',
			'foreignKey' => 'num_rpi'
		),
		'Despacho' => array(
			'className' => 'Despacho',
			'foreignKey' => 'codigo_despacho'
		)
	);

	var $hasMany = array(
		'Arquivo' => array(
			'className' => 'Arquivo',
			'foreignKey' => 'publicacao_id',
			'dependent' => true
		)
	);

	function CamposExportacao(){
		$colunas = [];
		$colunas['pasta'] = array('field'=>'pasta','label'=>'Pasta','checked'=>true,'width'=>10);
		$colunas['num_rpi'] = array('field'=>'num_rpi','label'=>'RPI','checked'=>true,'width'=>10);
		$colunas['despacho'] = array('field'=>'despacho','label'=>'Despacho','checked'=>true,'width'=>100);
		$colunas['tecnologia'] = array('field'=>'tecnologia','label'=>'Tecnologia','checked'=>true,'width'=>20);
		$colunas['status'] = array('field'=>'status','label'=>'Status','checked'=>true,'width'=>15);
		$colunas['prazo'] = array('field'=>'prazo','label'=>'Prazo','checked'=>true,'width'=>15);
		return $colunas;
	}
}
?>

	