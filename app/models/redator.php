<?php
class Redator extends AppModel {
	var $name = 'Redator';
	var $displayField = 'nome';

	var $hasMany = array(
		'Tecnologia' => array(
			'className' => 'Tecnologia',
			'foreignKey' => 'redator_id',
			'dependent' => false
		),
        'Desenho' => array(
            'className' => 'Desenho',
            'foreignKey' => 'redator_id',
            'dependent' => false
        )
	);
}
?>