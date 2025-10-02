<?php
class InventoresTecnologia extends AppModel {

	public $useTable = 'inventores_tecnologias';
	var $belongsTo = array('Inventor' , 'Tecnologia');	
}
?>