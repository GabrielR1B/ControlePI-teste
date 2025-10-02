<?php
class StatusInternacional extends AppModel {
	var $name = 'StatusInternacional';
	var $displayField = 'nome';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'PatenteInternacional' => array(
			'className' => 'PatenteInternacional',
			'foreignKey' => 'status_id',
			'dependent' => false
		)
	);
}
?>