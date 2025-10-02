<?php
class Rpi extends AppModel {
	public $name = 'Rpi';
	public $primaryKey = 'numero';

	var $hasMany = array(
		'Publicacao' => array(
			'className' => 'Publicacao',
			'foreignKey' => 'num_rpi',
			'dependent' => true
		)
	);
}
?>