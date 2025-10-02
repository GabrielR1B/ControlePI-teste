<?php
require_once('zip.lib.php');
require 'vendors/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class RpisController extends AppController {
	var $name = 'Rpis';
	var $uses = array('Rpi','Despacho');
	
	function index() {
		$this->Rpi->recursive = 1;
		$this->set('rpis', $this->Rpi->find('all',array('order'=>'numero DESC')));
	}
	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Número de RPI inválido', true));
			$this->redirect(array('action' => 'index'));
		}
		
		$this->Rpi->recursive = -1;
		$rpi = $this->Rpi->findByNumero($id);
		$publicacoes = $this->Rpi->Publicacao->find('all',array('conditions'=>array('Publicacao.num_rpi'=>$id)));
		$despachos = $this->Despacho->find('list');
		$this->loadModel('Status');
		
		$status	= $this->Status->find('list');
		$acompanhamentos = array('1'=>'UFMG','2'=>'Terceiros');

		if(isset($this->params['url']['status_id'])){
			$this->set('status_id', $this->params['url']['status_id']);
			
			foreach ($publicacoes as $key => $tecnologia) {
				if($tecnologia['Tecnologia']['status_id'] != $this->params['url']['status_id'])
				{
					unset($publicacoes[$key]);
				}				
			}
		}

		if(isset($this->params['url']['acompanhamento_id'])){
			$this->set('acompanhamento_id', $this->params['url']['acompanhamento_id']);
			
			foreach ($publicacoes as $key => $tecnologia) {
				if($this->params['url']['acompanhamento_id'] == 1)
				{
					if($tecnologia['Tecnologia']['acompanhamento'] != 1)
					{
						unset($publicacoes[$key]);
					}	
				}else{
					if($tecnologia['Tecnologia']['acompanhamento'] == 1)
					{
						unset($publicacoes[$key]);
					}
				}							
			}
		}

		$this->set(compact('rpi','despachos','publicacoes','status','acompanhamentos'));
	}

	function documentos ($id = null) {
		Configure::write('debug', 2);
    	$this->view = 'Media';
		$this->autoLayout = false;
		
		$this->Rpi->recursive = 2;
		$publicacoes = $this->Rpi->Publicacao->find('all', array('conditions'=>array('Publicacao.num_rpi'=>$id),'fields'=>array('Publicacao.id','Publicacao.tecnologia_id','Tecnologia.pasta')));

		$zip = new ZipArchive();
		if ($zip->open('arquivos_rpi_'.$id.'.zip', ZipArchive::CREATE) === TRUE)
		{
			$arquivos = array();
			foreach ($publicacoes as $publicacao) {
				foreach ($publicacao['Arquivo'] as $arquivo) {
					$zip->addFile('files/' . $arquivo['nomedisco'], $publicacao['Tecnologia']['pasta']. '_' .$arquivo['nomedisco']);
				}
			}    
		}
		$zip->close();

		$this->redirect('/arquivos_rpi_'.$id.'.zip');
  }

  function exportar($id = null){
	$this->autoRender = false;

	//echo $_GET['key1']; 
	//echo $_GET['key2'];
	//exit();

	$this->Rpi->recursive = -1;
	$rpi = $this->Rpi->findByNumero($id);

  	//Cria a planilha
	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();
	$writer = new Xlsx($spreadsheet);

	//Cria o header
	$sheet->getCellByColumnAndRow(1,1)->setValue('RPI ' . $id);
	$sheet->getCellByColumnAndRow(2,1)->setValue(date_format(date_create($rpi['Rpi']['data_publicacao']), 'd/m/Y'));
	$sheet->getCellByColumnAndRow(1,2)->setValue('Código');
	$sheet->getCellByColumnAndRow(2,2)->setValue('Título');
	$sheet->getCellByColumnAndRow(3,2)->setValue('Pasta');
	$sheet->getCellByColumnAndRow(4,2)->setValue('Tecnologia');
	$sheet->getCellByColumnAndRow(5,2)->setValue('Status');
	$sheet->getCellByColumnAndRow(6,2)->setValue('Prazo');
	$sheet->getCellByColumnAndRow(7,2)->setValue('Cumprida em');
	$sheet->getStyle('A1:G2')->getFont()->setBold(true);

	//$this->Rpi->Publicacao->recursive = 0;
	$resultado = $this->Rpi->Publicacao->find('all',array('conditions'=>array('Publicacao.num_rpi'=>$id)));
	$despachos = $this->Despacho->find('list');

	//Filtra pelo status_id
	if(isset($this->params['url']['status_id'])){
		$publicacoes = array();
		$this->set('status_id', $this->params['url']['status_id']);
		
		foreach ($resultado as $key => $tecnologia) {
			if($tecnologia['Tecnologia']['status_id'] == $this->params['url']['status_id'])
			{
				array_push($publicacoes, $tecnologia);
			}				
		}
	}else{
		if(isset($this->params['url']['acompanhamento_id'])){
			$publicacoes = array();
			$this->set('acompanhamento_id', $this->params['url']['acompanhamento_id']);
			
			foreach ($resultado as $key => $tecnologia) {
				if($this->params['url']['acompanhamento_id'] == '1')
				{
					if($tecnologia['Tecnologia']['acompanhamento'] == '1')
					{
						array_push($publicacoes, $tecnologia);
					}
				}else{
					if($tecnologia['Tecnologia']['acompanhamento'] != '1')
					{
						array_push($publicacoes, $tecnologia);
					}
				}							
			}
		}else{
			$publicacoes = $resultado;
		}
	}
	//elseif(isset($this->params['url']['acompanhamento_id'])){
	//	$publicacoes = array();
	//	$this->set('acompanhamento_id', $this->params['url']['acompanhamento_id']);
	//	
	//	foreach ($resultado as $key => $tecnologia) {
	//		if($this->params['url']['acompanhamento_id'] == '1')
	//		{
	//			if($tecnologia['Tecnologia']['acompanhamento'] == '1')
	//			{
	//				array_push($publicacoes, $tecnologia);
	//			}
	//		}else{
	//			if($tecnologia['Tecnologia']['acompanhamento'] != '1')
	//			{
	//				array_push($publicacoes, $tecnologia);
	//			}
	//		}							
	//	}
	//}{
	//	$publicacoes = $resultado;
	//}

	//Filtra pelo acompanhamento_id
	//if(isset($this->params['url']['acompanhamento_id'])){
	//	$publicacoes = array();
	//	$this->set('acompanhamento_id', $this->params['url']['acompanhamento_id']);
	//	
	//	foreach ($resultado as $key => $tecnologia) {
	//		if($this->params['url']['acompanhamento_id'] == '1')
	//		{
	//			if($tecnologia['Tecnologia']['acompanhamento'] == '1')
	//			{
	//				array_push($publicacoes, $tecnologia);
	//			}
	//		}else{
	//			if($tecnologia['Tecnologia']['acompanhamento'] != '1')
	//			{
	//				array_push($publicacoes, $tecnologia);
	//			}
	//		}							
	//	}
	//}else{
	//	$publicacoes = $resultado;
	//}

	foreach ($publicacoes as $key => $publicacao) {
		//print_r($publicacao);
		//$sheet->getCellByColumnAndRow(1,$key+3)->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_GENERAL);
		$sheet->setCellValueExplicit('A'.strval($key+3), $publicacao['Publicacao']['codigo_despacho'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
		$sheet->setCellValueExplicit('B'.strval($key+3), $publicacao['Despacho']['titulo'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
		$sheet->setCellValueExplicit('C'.strval($key+3), $publicacao['Tecnologia']['pasta'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
		$sheet->setCellValueExplicit('D'.strval($key+3), $publicacao['Tecnologia']['num_pedido'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
		
		if($publicacao['Publicacao']['status_providencia_id'] == '2')
		{
			$sheet->setCellValueExplicit('E'.strval($key+3), 'PENDENTE', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
		}

		if($publicacao['Publicacao']['status_providencia_id'] == '3')
		{
			$sheet->setCellValueExplicit('E'.strval($key+3), 'CUMPRIDA', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
		}

		if($publicacao['Publicacao']['status_providencia_id'] == '2' || $publicacao['Publicacao']['status_providencia_id'] == '3')
		{
			$sheet->setCellValueExplicit('F'.strval($key+3), date_format(date_create($publicacao['Publicacao']['prazo']), 'd/m/Y'), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
		}

		if($publicacao['Publicacao']['status_providencia_id'] == '3')
		{
			$sheet->setCellValueExplicit('G'.strval($key+3), date_format(date_create($publicacao['Publicacao']['cumprida_em']), 'd/m/Y'), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
		}
		
	}

	ob_start();
	$writer->save("php://output");
	$xlsData = ob_get_contents();
	ob_end_clean();
	$response =  array(
       	'op' => 'ok',
       	'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
    );

    die(json_encode($response));
  }
}
?>