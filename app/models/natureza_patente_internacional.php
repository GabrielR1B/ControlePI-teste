<?php
class NaturezaPatenteInternacional extends AppModel {
	 var $name = 'NaturezaPatenteInternacional';
	 var $displayField = 'nome';
	 var $useTable = "natureza_patentes_internacionais";
	
	var $validate = array(
		'natureza_tecnologia' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		)
	);

	var $hasMany = array(
		'PatenteInternacional' => array(
			'className' => 'PatenteInternacional',
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