<?php
class AppController extends Controller {
	var $helpers = array('Html','Form','Time','Textile','Session', 'Excel');
	var $components = array('Auth' => array(
										'authorize' => 'actions',
										'loginError' => 'Nome de usuário ou senha inválidos',
										'authError' => 'Você não pode acessar essa página',
										'loginRedirect' => array(
															'admin' => false,
															'controller' => 'users',
															'action' => 'count'
															),
										),
							'Session',
							'Acl'
							);
}

?>