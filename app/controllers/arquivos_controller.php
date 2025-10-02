<?php
class ArquivosController extends AppController {

	var $name = 'Arquivos';

	function index() {
		$this->redirect(array('controller' => 'tecnologias'));
	}
	
	function ajaxExcluirArquivo() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		// ID do arquivo
		$id = $_GET['id'];

		// Deletar do banco (lembrando que há uma beforeDelete no model que remove o arquivo do disco)
		$resultado = $this->Arquivo->delete($id);
		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Arquivo excluído com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao excluir este arquivo. Saia do sistema e tente novamente.", true) );
		}
		
	}//ajaxExcluirArquivo
	
	function download ($id = null) {
		Configure::write('debug', 0);
    	$this->view = 'Media';
		$this->autoLayout = false;
		
		$this->Arquivo->recursive = -1;
		$arquivo = $this->Arquivo->findById($id);
		if (!$arquivo) {
			$this->redirect(array('controller' => 'tecnologias'));
		}

		$path            = APP . 'webroot/files' . DS;
		$arquivoDisco    = $arquivo['Arquivo']['nomedisco'];
		$arquivoOriginal = $arquivo['Arquivo']['nomeoriginal'];
		$mimetype        = $arquivo['Arquivo']['mimetype'];
		
		$arquivoValido = file_exists($path . $arquivoDisco);
		if (!$arquivoValido) {
			$opts = array( 
			        'name' => 'Not found', 
			        'code' => 404, 
			        'message' => 'O Arquivo solicitado não foi encontrado', 
			        'base' => $this->base
			); 
			$this->cakeError('error', array($opts));
		}
		
		$file = new File($path . $arquivoDisco);
		$ext = $file->ext();

		// remover a extensão do arquivo
		$arquivoOriginal = basename($arquivoOriginal, '.' . $ext);
		
    	$params = array(
		     'id' => $arquivoDisco,
		     'name' => $arquivoOriginal,
		     'download' => false,
		     'extension' => $ext,
		     'mimeType' => array($ext => $mimetype),
		     'path' => $path
    	);


		
    	$this->set($params);

		if (!$this->render()) {
			print_r("O arquivo solicitado não foi encontrado no servidor");exit;
		}
  }//download

}