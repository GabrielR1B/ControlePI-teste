<?php
	class UsersController extends AppController {
		var $name='Users';
	
		var $paginate = array(
			'limit' => 100,
			'recursive' => 1
		);
	
		public function beforeFilter() {
			parent::beforeFilter();
			$this->Auth->allow(array('login', 'logout','count'));
			Security::setHash('sha256'); // Setamos o tipo de hash que iremos gerar
		}

		public function add() {
			if (!empty($this->data)) {
				$this->User->create();
				if ($this->User->save($this->data)) {
					$this->Session->setFlash('User created!');
					$this->redirect(array('action'=>'login'));
				} else {
					$this->Session->setFlash('Please correct the
					errors');
				}
			}
			$this->set('groups', $this->User->Group->find('list'));
		}
	
		public function login() {

		}

		public function logout() {
			$this->Session->destroy();
			$this->redirect($this->Auth->logout());
		}

		public function changePassword($id = null) { 
    		if (!empty($this->data)) { 
	    		$pwd_new = $this->data['User']['password']; // obtém o campo password do formulário
				$pwd_hashed = AuthComponent::password($pwd_new); // da um hash no password
		
				$pwd_confirmation_new = $this->data['User']['password_confirmation']; // obtém o campo password confirmation do formulário
				$pwd_confirmation_hashed = AuthComponent::password($pwd_confirmation_new); // da um hash no password_confirmation
		
				$this->data['User']['password'] = $pwd_hashed;
				$this->data['User']['password_confirmation'] = $pwd_confirmation_hashed;			
		
    			if($this->User->save($this->data)){
        		    $this->Session->setFlash('Password changed successfully');
       			}
        		else
        		    $this->Session->setFlash('The password was not changed'); 
    		}
    		$this->set('id',$id);
		}
	
		public function view($id=NULL) {
			$this->set('id',$id);
			$user = $this->User->findById($id);
			$this->set('user',$user);
		}
	
		public function index() {
			$this->User->recursive = 0;
			$this->set('users', $this->paginate(array()));
		}

		public function edit($id = null) {
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Invalid user', true));
				$this->redirect(array('action' => 'index'));
			}
			if (!empty($this->data)) {
				if ($this->User->save($this->data)) {
					$this->Session->setFlash(__('The user has been saved', true));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The user could not be saved. Please, try again.', true));
				}
			}
			if (empty($this->data)) {
				$this->data = $this->User->read(null, $id);
				$this->set('id',$id);
			}

			$groups = $this->User->Group->find('list');
			$this->set('groups',$groups);
		}

		public function delete($id = null) {
			if (!$id) {
				$this->Session->setFlash(__('Invalid id for user', true));
				$this->redirect(array('action'=>'index'));
			}
			if ($this->User->delete($id)) {
				$this->Session->setFlash(__('User deleted', true));
				$this->redirect(array('action'=>'index'));
			}
			$this->Session->setFlash(__('User was not deleted', true));
			$this->redirect(array('action' => 'index'));
		}

		public function count(){
			$this->autoRender = false;
			if($this->Session->read('Auth.User.id')){
				$user_id = $this->Session->read('Auth.User.id');
				$user_hits = $this->Session->read('Auth.User.hits');
				$user_hits++;
				$this->User->id = $user_id;
				$this->User->saveField('hits', $user_hits);
				echo $user_hits;
				$this->redirect(array('controller'=>'tecnologias', 'action'=>'index'));
			}

		}
	}



/*
class UsersController extends AppController {

    var $name = 'Users';    
 
    function beforeFilter() {
        parent::beforeFilter();
				// permite gerar novas senhas com o hash do site
				// if (!empty($this->data)) {
				// 	// print_r($this->data);exit;
				// 
				// 			    $hashedPasswords = $this->Auth->hashPasswords($this->data);
				// 			    pr($hashedPasswords);exit;
				// 	
				// }
				//$this->Auth->allow('add');
				$this->Auth->loginRedirect = array('controller' => 'tecnologias', 'action'=>'index');
    }
	
	function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function add() {
		if (!empty($this->data)) {
			$this->User->create();
				if ($this->User->save($this->data)) {
					$this->Session->setFlash('User created!');
					$this->redirect(array('action'=>'index'));
				} else {
					$this->Session->setFlash('Please correct the
					errors');
				}
		}
		$this->set('groups', $this->User->Group->find('list'));
	}

	function delete() {
		$this->User->delete();
		$this->Session->setFlash('User deleted');
		$this->redirect(array('action' => 'index'));
	}

    function login() {
		if (!empty($this->data) 
		&& !empty($this->Auth->data['User']['username']) 
		&& !empty($this->Auth->data['ser']['password'])) {
			$user = $this->User->find('first', array(
													'conditions' => array(
																		'User.email' => $this->Auth->data['User']		['username'],'User.password' => $this		->Auth->data['User']['	password']
																		),'recursive' => -1
													)
									);
			if (!empty($user) && $this->Auth->login($user)) {
					$link = mysql_connect('localhost', 'root', 'root');
					$sql = "UPDATE users SET hits = hits + 1 WHERE username=$user";
					mysql_query($sql, $link);
				if ($this->Auth->autoRedirect) {
					//$this->redirect($this->Auth->redirect());
				}
			} else {
				$this->Session->setFlash($this->Auth->loginError, $this->Auth->flashElement, array(), 'auth');
			}
		}
	}

    function logout() {
        $this->redirect($this->Auth->logout());
    }

	function dashboard() {
		$groupName = $this->User->Group->field('name',array('Group.id'=>$this->Auth->user('group_id')));
		$this->redirect(array('action'=>strtolower($groupName)));
	}
}*/
?>