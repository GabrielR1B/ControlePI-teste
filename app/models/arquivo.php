<?php
class Arquivo extends AppModel {

	var $belongsTo = array(
		'Tecnologia' => array(
			'className' => 'Tecnologia',
			'foreignKey' => 'tecnologia_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Publicacao' => array(
			'className' => 'Publicacao',
			'foreignKey' => 'publicacao',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	// remover o arquivo em disco antes de deletar do banco
	function beforeDelete()
	{
		// exclui o arquivo em disco antes de remover do banco
		// $this->recursive = -1;
		$arquivo = $this->findById($this->id);
		if (!$arquivo) {
			// por algum motivo o arquivo com este ID não existe no banco, prosseguir com a rotina de deletar
			return true;
		}

		$path            = APP . 'webroot/files' . DS;
		$arquivoDisco    = $path . $arquivo['Arquivo']['nomedisco'];
		
		if ( file_exists($arquivoDisco) ) {
			@unlink($arquivoDisco);
		}
		// arquivo excluido, prosseguir
		return true;		
	}
	
}
?>