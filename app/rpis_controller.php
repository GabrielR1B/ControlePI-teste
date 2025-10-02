<?php
require_once('zip.lib.php');

class RpisController extends AppController {
	var $name = 'Rpis';
	var $uses = array('Rpi','Despacho');
	
	function index() {
		$this->Rpi->recursive = 1;
		$this->set('rpis', $this->Rpi->find('all',array('order'=>'numero DESC')));
	}
	
	function view($id = null) {
		//print_r($this->params['url']['somente_controladas']);
		//exit();

		if (!$id) {
			$this->Session->setFlash(__('Número de RPI inválido', true));
			$this->redirect(array('action' => 'index'));
		}
		
		$this->Rpi->recursive = -1;
		$rpi = $this->Rpi->findByNumero($id);
		$publicacoes = $this->Rpi->Publicacao->find('all',array('conditions'=>array('Publicacao.num_rpi'=>$id)));
		$despachos = $this->Despacho->find('list');

		if(isset($this->params['url']['somente_controladas'])  && $this->params['url']['somente_controladas'] == "true")
		{
			$this->set('somente_controladas', 1);
		}else{
			$this->set('somente_controladas', 0);
		}

		$this->set(compact('rpi','despachos','publicacoes'));
	}

	function documentos ($id = null) {
		Configure::write('debug', 2);
    	$this->view = 'Media';
		$this->autoLayout = false;
		
		$this->Rpi->recursive = 2;
		$publicacoes = $this->Rpi->Publicacao->find('all', array('conditions'=>array('Publicacao.num_rpi'=>$id),'fields'=>array('Publicacao.id','Publicacao.tecnologia_id','Tecnologia.pasta')));
		//print_r($publicacoes);
		//exit();

		$zip = new ZipArchive();
		if ($zip->open('arquivos_rpi_'.$id.'.zip', ZipArchive::CREATE) === TRUE)
		{
			$arquivos = array();
			foreach ($publicacoes as $publicacao) {
				foreach ($publicacao['Arquivo'] as $arquivo) {
					//print_r($arquivo);
					//$arquivo['tecnologia_id'] = $publicacao['Publicacao']['tecnologia_id'];
					//$arquivo['pasta'] = $publicacao['Tecnologia']['pasta'];
					//array_push($arquivos, $arquivo);
					$zip->addFile('files/' . $arquivo['nomedisco'], $arquivo['nomedisco']);
				}
			}    
		}
		$zip->close();

		$this->redirect('/arquivos_rpi_'.$id.'.zip');

		//$path = APP . 'webroot' . DS;
//
		//$file = new File($path . 'arquivos_rpi_'.$id.'.zip');
		////
//
		//$ext = $file->ext();
		//print_r($ext);
//
		//// remover a extensão do arquivo
		////$arquivoOriginal = basename('arquivos_rpi_'.$id.'.zip', '.' . $ext);
//
		//
    	//$params = array(
		//     'id' => 'arquivos_rpi_'.$id.'.zip',
		//     'name' => 'arquivos_rpi_'.$id.'.zip',
		//     'download' => false,
		//     'extension' => '.zip',
		//     'mimeType' => array($ext => $mimetype),
		//     'path' => $path
    	//);
			
    	//$this->set($params);


  }
}
?>