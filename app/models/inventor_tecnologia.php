<?php
class InventorTecnologia extends AppModel {

	public $name = 'InventorTecnologia';
	public $useTable = 'inventores_tecnologias';
	var $belongsTo = array('Inventor' , 'Tecnologia');	
}
?>