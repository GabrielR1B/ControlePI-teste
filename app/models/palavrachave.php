<?php
class Palavrachave extends AppModel {
	var $name = 'Palavrachave';
	var $displayField = 'palavra';

	var $validate = array(
			'palavra' => array('rule'=>'isUnique','message'=>'Esta palavra-chave já existe no banco de dados.')
		);
	
	var $hasAndBelongsToMany = array(
		'Tecnologia' => array(
			'className' => 'Tecnologia',
			'joinTable' => 'palavraschave_tecnologias',
			'foreignKey' => 'palavrachave_id',
			'associationForeignKey' => 'tecnologia_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

	function isUnique($data){

		if($this->find('count',array('conditions'=>array('Palavrachave.palavra'=>$data['palavra'])))){
			return false;
		}else{
			return true;
		}
		
	}
	
}
?>