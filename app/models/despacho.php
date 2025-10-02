<?php
class Despacho extends AppModel {
	public $name = 'Despacho';
	public $primaryKey = 'codigo';
	public $displayField = 'codigo_nome';

	public $virtualFields = array(
    	'codigo_nome' => 'CONCAT(Despacho.codigo, " - ", Despacho.titulo)'
	);

	var $hasMany = array(
		'Publicacao' => array(
			'className' => 'Publicacao',
			'foreignKey' => 'codigo_despacho',
			'dependent' => true
		)
	);
}
?>