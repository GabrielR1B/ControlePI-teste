<?php
class Group extends AppModel {
	var $name = 'Group';
	var $displayField = 'name';
	var $actsAs = array('Acl' => 'requester');

	var $validate = array(
		'group' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		)
	);

	var $hasMany = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'group_id',
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

	function parentNode() {
		if (empty($this->id) && empty($this->data)) {
			return null;
		}
		$data = $this->data;
		if (empty($data)) {
		$data = $this->find('first', array(
										'conditions' => array('id' => $this->id),
										'fields' => array('parent_id'),
										'recursive' => -1
										)
							);
		}

		if (!empty($data[$this->alias]['parent_id'])) {
			return $data[$this->alias]['parent_id'];
		}
		return null;
	}
}
?>