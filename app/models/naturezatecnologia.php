<?php
class NaturezaTecnologia extends AppModel {
	 var $name = 'NaturezaTecnologia';
	 var $displayField = 'name';
	
	var $validate = array(
		'natureza_tecnologia' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		)
	);

	var $hasMany = array(
		'Tecnologia' => array(
			'className' => 'Tecnologia',
			'foreignKey' => 'natureza_id',
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
	);
}
?>