<?php
class User extends AppModel {
	var $name = 'User';
	var $displayField = 'first_name';
	var $actsAs = array('Acl' => 'requester');

	public $validate = array( 
     
        'password' => array( 
            'If empty' => array( 
                'rule' => 'pwdDefault',
                'message' => 'Enter a valid password',
                //'on' => 'create'
            ), 
            'Match passwords' => array( 
                'rule' => 'matchPasswords', 
                'message' => 'your passwords do not match' ,
                'on' => 'update'
            ),
            'Match passwords on userscontroller add' => array(
                'rule' => 'matchPasswordsAdd',
                'message' => 'your passwords do not match',
                'on' => 'create'
            )
        ), 
        'password_confirmation' => array( 
            'Not empty' => array( 
                'rule' => 'notEmpty',
                'message' => 'please confirm your password' 
            ) 
        ), 
        'current_password' => array( 
            'notempty' => array(
                'rule' => 'notEmpty',
                'message' => 'please enter your old password'
            ), 
            'check password' => array(
                'rule' => 'checkPassword', 
                'message' => 'your password is not correct'
            ) 
        ),
        'username' => array(
            'rule' => 'notEmpty'
        ),
        'first_name' => array(
            'rule' => 'notEmpty'
        ),
        'last_name' => array(
            'rule' => 'notEmpty'
        ),
        'email' => array(
            'rule' => 'email',
            'message' => 'Enter a valid email'
        )
    );

	var $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Tecnologia' => array(
			'className' => 'Tecnologia',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
        'Desenho' => array(
            'className' => 'Desenho',
            'foreignKey' => 'user_id',
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

	function get($field = null) {
		$user = Configure::read('User');
		if (empty($user) || (!empty($field) && !array_key_exists($field, $user))) {return false;}
		return !empty($field) ? $user[$field] : $user;
	}

	function isAuthorized() {
		$role = $this->Auth->user('role');
		$neededRole = null;
		$prefix = !empty($this->params['prefix']) ?
		$this->params['prefix'] :null;
		if (		!empty($prefix) && in_array($prefix, Configure::read('Routing.prefixes'))) {
			$neededRole = $prefix;
		}
		return (
		empty($neededRole) ||
		strcasecmp($role, 'admin') == 0 ||
		strcasecmp($role, $neededRole) == 0
		);
	}

	function parentNode() {
	}

	function bindNode($object) {
		if (!empty($object[$this->alias]['group_id'])) {
			return array(
						'model' => 'Group',
						'foreign_key' => $object[$this->alias]['group_id']
						);
		}
	}

    public function matchPasswords($data) {
        if ($this->data['User']['password'] == $this->data['User']['password_confirmation'])
            return true; 
        $this->invalidate('password_confirmation', 'your passwords do not match'); 
            return false; 
    } 
     
    public function checkPassword($data) { 

        $uid = CakeSession::read("Auth.User.id");// Obtém a id atual do usuário logado

        $current_password = AuthComponent::password($data['current_password']);// faz o hash da senha que o usuário passou no formulário

        $pwd = $this->field('password', array('id' => $uid)); // pega a senha o BD correspondente ao ID do usuário

        if($current_password == $pwd){// compara se a senha digitada no formulário e a do banco de dados é igual
            return true;      
        } 
        return false; 
    }

    public function pwdDefault($data){
        if($this->data['User']['password'] == "e4296522545b6b3ad7a2d52c1ec200343ef75ed49a34e0182e0df7ea3b6b02ea") {
            return false;
        }
        else
            return true;
    }

    public function matchPasswordsAdd($data) {
        $password_confirmation_hashed = AuthComponent::password($this->data['User']['password_confirmation']);

        if ($this->data['User']['password'] == $password_confirmation_hashed)
            return true;
        $this->invalidate('password_confirmation', 'your passwords do not match'); 
            return false;
    }
}
?>