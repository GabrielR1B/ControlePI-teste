<?php
class DesenhoInventor extends AppModel {

	public $name = 'DesenhoInventor';
	public $useTable = 'desenhos_inventores';
	var $belongsTo = array('Inventor' , 'Desenho');	
}
?>