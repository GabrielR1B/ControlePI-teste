<?php
class DATABASE_CONFIG {
	
	//var $default = array(
	//	'driver' => 'mysql',
	//	'persistent' => false,
	//	'host' => 'localhost',
	//	'login' => 'user_conectdb',
	//	'password' => '#t8@BGTRfrt',
	//	'database' => 'ctit_controle_ativos',
	//	'encoding' => 'UTF8'
	//);

	var $default = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => 'inovacao',
		'database' => 'ctit_controle_ativos',
		'encoding' => 'UTF8'
	);
	
	/*
	var $remote = array(
		'driver'     => 'mysql',
		'persistent' => false,
		'host'       => 'localhost',
		'login'      => 'ctit',
		'password'   => 'inovacao',
		'database'   => 'ctit_controle_ativos',
		'encoding'   => 'utf8',
	);
	*/
	//function __construct() {
	//	// print_r($_SERVER);exit;
	//	$ip = trim($_SERVER['REMOTE_ADDR']);
	//	// print_r($ip);exit;
	//	if ( !strcmp('127.0.0.1', $ip) || !strcmp('150.164.59.149', $ip) ) {
	//	 	$this->default = $this->default;
	//	} else {
	//		$this->default = $this->remote;
	//	}
	//}
	
}
?>
