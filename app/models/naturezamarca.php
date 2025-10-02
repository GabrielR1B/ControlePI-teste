<?php
class NaturezaMarca extends AppModel {
	 var $name = 'NaturezaMarca';
	
	var $validate = array(
		'natureza_marca' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		)
	);

	var $hasMany = array(
		'Marca' => array(
			'className' => 'Marca',
			'foreignKey' => 'naturezamarca_id',
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