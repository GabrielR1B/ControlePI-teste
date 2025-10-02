<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php
 *
 * This is an application wide file to load any function that is not used within a class
 * define. You can also use this to include or require any files in your application.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * App::build(array(
 *     'plugins' => array('/full/path/to/plugins/', '/next/full/path/to/plugins/'),
 *     'models' =>  array('/full/path/to/models/', '/next/full/path/to/models/'),
 *     'views' => array('/full/path/to/views/', '/next/full/path/to/views/'),
 *     'controllers' => array('/full/path/to/controllers/', '/next/full/path/to/controllers/'),
 *     'datasources' => array('/full/path/to/datasources/', '/next/full/path/to/datasources/'),
 *     'behaviors' => array('/full/path/to/behaviors/', '/next/full/path/to/behaviors/'),
 *     'components' => array('/full/path/to/components/', '/next/full/path/to/components/'),
 *     'helpers' => array('/full/path/to/helpers/', '/next/full/path/to/helpers/'),
 *     'vendors' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
 *     'shells' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
 *     'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
 * ));
 *
 */

configure::write('Config.language', 'por');
	
$ip = trim($_SERVER['REMOTE_ADDR']);
$docroot = trim($_SERVER['DOCUMENT_ROOT']);

if ( !strcmp('127.0.0.1', $ip) ) {
	if ( stristr($docroot, 'E:/apps/') ) {
		define('BASE_URL', 'http://www.ctit.ufmg.br/controle-pi/');
		define('PATH_ARQUIVOS', WWW_ROOT.'files'.DS);			
	} else {
		define('BASE_URL', 'http://www.ctit.ufmg.br/controle-pi/');
		define('PATH_ARQUIVOS', WWW_ROOT.'files'.DS);	
	}
} else {
	//define('BASE_URL', 'http://localhost/controle-pi/');
	define('BASE_URL', 'http://www.ctit.ufmg.br/controle-pi/');
	define('PATH_ARQUIVOS', WWW_ROOT.'files'.DS);
}

/**
 * As of 1.3, additional rules for the inflector are added below
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

// Alteração do inflector
$_uninflected = array('atlas', 'lapis', 'onibus', 'pires', 'virus', '.*x');
$_pluralIrregular = array(
	'abdomens'     => 'abdomen',
	'alemao'       => 'alemaes',
	'artesa'       => 'artesaos',
	'as'           => 'ases',
	'bencao'       => 'bencaos',
	'cao'          => 'caes',
	'capelao'      => 'capelaes',
	'capitao'      => 'capitaes',
	'chao'         => 'chaos',
	'charlatao'    => 'charlataes',
	'cidadao'      => 'cidadaos',
	'consul'       => 'consules',
	'cristao'      => 'cristaos',
	'dificil'      => 'dificeis',
	'email'        => 'emails',
	'escrivao'     => 'escrivaes',
	'fossel'       => 'fosseis',
	'germens'      => 'germen',
	'grao'         => 'graos',
	'hifens'       => 'hifen',
	'irmao'        => 'irmaos',
	'liquens'      => 'liquen',
	'mal'          => 'males',
	'mao'          => 'maos',
	'orfao'        => 'orfaos',
	'pais'         => 'paises',
	'pai'          => 'pais',
	'pao'          => 'paes',
	'perfil'       => 'perfis',
	'projetil'     => 'projeteis',
	'reptil'       => 'repteis',
	'sacristao'    => 'sacristaes',
	'situacao'     => 'situacoes',
	'software'     => 'softwares', // Adicionado Manualmente
	'sotao'        => 'sotaos',
	'status'       => 'status', // adicionado manualmente
	'palavrachave' => 'palavraschave', // adicionado manualmente
	'tabeliao'     => 'tabeliaes',
	'user'         => 'users' // adicionado por conta do Auth Component


);

Inflector::rules('singular', array(
	'rules' => array(
		'/^(.*)(oes|aes|aos)$/i' => '\1ao',
		'/^(.*)(coes)$/i'        => '\1cao',
		'/^(.*)(a|e|o|u)is$/i'   => '\1\2l',
		'/^(.*)e?is$/i'          => '\1il',
		'/^(.*)(r|s|z)es$/i'     => '\1\2',
		'/^(.*)ns$/i'            => '\1m',
		'/^(.*)s$/i'             => '\1',

	),
	'uninflected' => $_uninflected,
	'irregular'   => array_flip($_pluralIrregular)

), true);

Inflector::rules('plural', array(
	'rules' => array(
		'/^(.*)ao$/i'         => '\1oes',
		'/^(.*)cao$/i'        => '\1coes',
		'/^(.*)(r|s|z)$/i'    => '\1\2es',
		'/^(.*)(a|e|o|u)l$/i' => '\1\2is',
		'/^(.*)il$/i'         => '\1is',
		'/^(.*)(m|n)$/i'      => '\1ns',
		'/^(.*)$/i'           => '\1s'

	),
	'uninflected' => $_uninflected,
	'irregular' => $_pluralIrregular
), true);

Inflector::rules('transliteration', array(
	'/À|Á|Â|Ã|Ä|Å/'    => 'A',
	'/È|É|Ê|Ë/'          => 'E',
	'/Ì|Í|Î|Ï/'          => 'I',
	'/Ò|Ó|Ô|Õ|Ö|Ø/'    => 'O',
	'/Ù|Ú|Û|Ü/'          => 'U',
	'/Ç/'                   => 'C',
	'/Ð/'                   => 'D',
	'/Ñ/'                   => 'N',
	'/Š/'                   => 'S',
	'/Ý|Ÿ/'                => 'Y',
	'/Ž/'                   => 'Z',
	'/Æ/'                   => 'AE',
	'/ß/'                   => 'ss',
	'/Œ/'                   => 'OE',
	'/à|á|â|ã|ä|å|ª/' => 'a',
	'/è|é|ê|ë|&/'        => 'e',
	'/ì|í|î|ï/'          => 'i',
	'/ò|ó|ô|õ|ö|ø|º/' => 'o',
	'/ù|ú|û|ü/'          => 'u',
	'/ç/'                   => 'c',
	'/ð/'                   => 'd',
	'/ñ/'                   => 'n',
	'/š/'                   => 's',
	'/ý|ÿ/'                => 'y',
	'/ž/'                   => 'z',
	'/æ/'                   => 'ae',
	'/œ/'                   => 'oe',
	'/ƒ/'                   => 'f'
));

/* -------------------------------------------------------------------
 * The settings below have to be loaded to make the acl plugin work.
 * -------------------------------------------------------------------
 *
 * See how to include these settings in the README file
 */

/*
 * The model name used for the user role (typically 'Role' or 'Group')
 */
Configure :: write('acl.aro.role.model', 'Group');

/*
 * The primary key of the role model
 *
 * (can be left empty if your primary key's name follows CakePHP conventions)('id')
 */
Configure :: write('acl.aro.role.primary_key', 'id');

/*
 * The foreign key's name for the roles
 *
 * (can be left empty if your foreign key's name follows CakePHP conventions)(e.g. 'role_id')
 */
Configure :: write('acl.aro.role.foreign_key', 'group_id');

/*
 * The model name used for the user (typically 'User')
 */
Configure :: write('acl.aro.user.model', 'User');

/*
 * The primary key of the user model
 *
 * (can be left empty if your primary key's name follows CakePHP conventions)('id')
 */
Configure :: write('acl.aro.user.primary_key', 'id');

/*
 * The name of the database field that can be used to display the role name
 */
Configure :: write('acl.aro.role.display_field', 'name');

/*
 * You can add here role id(s) that are always allowed to access the ACL plugin (by bypassing the ACL check)
 * (This may prevent a user from being rejected from the ACL plugin after a ACL permission update)
 */
Configure :: write('acl.role.access_plugin_role_ids', array(1));

/*
 * You can add here users id(s) that are always allowed to access the ACL plugin (by bypassing the ACL check)
 * (This may prevent a user from being rejected from the ACL plugin after a ACL permission update)
 */
Configure :: write('acl.role.access_plugin_user_ids', array(1));

/*
 * The users table field used as username in the views
 * It may be a table field or a SQL expression such as "CONCAT(User.lastname, ' ', User.firstname)" for MySQL or "User.lastname||' '||User.firstname" for PostgreSQL
 */
Configure :: write('acl.user.display_name', "User.username");

/*
 * Indicates whether the presence of the Acl behavior in the user and role models must be verified when the ACL plugin is accessed
 */
Configure :: write('acl.check_act_as_requester', true);

/*
 * Add the ACL plugin 'locale' folder to your application locales' folders
 */
App :: build(array('locales' => App :: pluginPath('acl') . DS . 'locale'));

/*
 * Indicates whether the roles permissions page must load through Ajax
 */
Configure :: write('acl.gui.roles_permissions.ajax', false);

/*
 * Indicates whether the users permissions page must load through Ajax
 */
Configure :: write('acl.gui.users_permissions.ajax', false
	);
