<?php
require 'vendors/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PublicacoesController extends AppController {

	var $name = 'Publicacoes';

	var $paginate = array(
		'limit' => 50,
		'order' => array(
			'Publicacao.id' => 'desc',
		)
	);
	
	function index() {
		$data = array('Publicacao'=>array());

		$condicoes = array();
		//$condicoes['Tecnologia.status_id'] = array('NULL','1');

		if(isset($this->params['url']['rpi_inicial']) && $this->params['url']['rpi_inicial']!=''){
			$condicoes['Publicacao.num_rpi >='] = $this->params['url']['rpi_inicial'];
			$data['Publicacao']['rpi_inicial'] = $this->params['url']['rpi_inicial'];
		}

		if(isset($this->params['url']['rpi_final']) && $this->params['url']['rpi_final']!=''){
			$condicoes['Publicacao.num_rpi <='] = $this->params['url']['rpi_final'];
			$data['Publicacao']['rpi_final'] = $this->params['url']['rpi_final'];	
		}

		//Filtra pela data de publicação inicial
		if(isset($this->params['url']['data_publicacao_inicial']) && $this->params['url']['data_publicacao_inicial']!=''){
			$data_publicacao_inicial = date_parse_from_format("d/m/Y", $this->params['url']['data_publicacao_inicial']);
			if(!checkdate($data_publicacao_inicial['month'], $data_publicacao_inicial['day'], $data_publicacao_inicial['year'])){
				$this->Session->setFlash(__('Data de publicação inicial inválida', true));
				$this->redirect(array('action' => 'index'));
			}
			$condicoes['Rpi.data_publicacao >='] = sprintf('%d-%d-%d',$data_publicacao_inicial['year'],$data_publicacao_inicial['month'],$data_publicacao_inicial['day']);	
			$data['Publicacao']['data_publicacao_inicial'] = $this->params['url']['data_publicacao_inicial'];	
		}

		//Filtra pela data de publicação final
		if(isset($this->params['url']['data_publicacao_final']) && $this->params['url']['data_publicacao_final']!=''){
			$data_publicacao_final = date_parse_from_format("d/m/Y", $this->params['url']['data_publicacao_final']);
			if(!checkdate($data_publicacao_final['month'], $data_publicacao_final['day'], $data_publicacao_final['year'])){
				$this->Session->setFlash(__('Data de publicação final inválida', true));
				$this->redirect(array('action' => 'index'));
			}
			$condicoes['Rpi.data_publicacao <='] = sprintf('%d-%d-%d',$data_publicacao_final['year'],$data_publicacao_final['month'],$data_publicacao_final['day']);	
			$data['Publicacao']['data_publicacao_final'] = $this->params['url']['data_publicacao_final'];
		}

		if(isset($this->params['url']['data_vencimento_inicial']) && $this->params['url']['data_vencimento_inicial']!=''){
			$data_vencimento_inicial = date_parse_from_format("d/m/Y", $this->params['url']['data_vencimento_inicial']);
			if(!checkdate($data_vencimento_inicial['month'], $data_vencimento_inicial['day'], $data_vencimento_inicial['year'])){
				$this->Session->setFlash(__('Data de vencimento inicial inválida', true));
				$this->redirect(array('action' => 'index'));
			}
			$condicoes['Publicacao.prazo >='] = sprintf('%d-%d-%d',$data_vencimento_inicial['year'],$data_vencimento_inicial['month'],$data_vencimento_inicial['day']);	
			$condicoes['Publicacao.status_providencia_id ='] = 2;
			$data['Publicacao']['data_vencimento_inicial'] = $this->params['url']['data_vencimento_inicial'];
		}

		if(isset($this->params['url']['data_vencimento_final']) && $this->params['url']['data_vencimento_final']!=''){
			$data_vencimento_final = date_parse_from_format("d/m/Y", $this->params['url']['data_vencimento_final']);
			if(!checkdate($data_vencimento_final['month'], $data_vencimento_final['day'], $data_vencimento_final['year'])){
				$this->Session->setFlash(__('Data de vencimento final inválida', true));
				$this->redirect(array('action' => 'index'));
			}
			$condicoes['Publicacao.prazo <='] = sprintf('%d-%d-%d',$data_vencimento_final['year'],$data_vencimento_final['month'],$data_vencimento_final['day']);	
			$condicoes['Publicacao.status_providencia_id ='] = 2;
			$data['Publicacao']['data_vencimento_final'] = $this->params['url']['data_vencimento_final'];
		}

		if(isset($this->params['url']['despacho_id']) && $this->params['url']['despacho_id']!=''){
			$condicoes['Publicacao.codigo_despacho ='] = $this->params['url']['despacho_id'];	
			$data['Publicacao']['despacho_id'] = $this->params['url']['despacho_id'];
		}

		if(isset($this->params['url']['pasta']) && $this->params['url']['pasta']!=''){
			$condicoes['Tecnologia.pasta ='] = $this->params['url']['pasta'];	
			$data['Publicacao']['pasta'] = $this->params['url']['pasta'];
		}

		if(isset($this->params['url']['status_id']) && $this->params['url']['status_id']!=''){
			$condicoes['Tecnologia.status_id ='] = $this->params['url']['status_id'];	
			$data['Publicacao']['status_id'] = $this->params['url']['status_id'];
			$this->set('status_id', $this->params['url']['status_id']);
		}

		if(isset($this->params['url']['somente_pendentes']) && $this->params['url']['somente_pendentes']=='1'){
			$condicoes['Publicacao.status_providencia_id ='] = 2;
			$data['Publicacao']['somente_pendentes'] = $this->params['url']['somente_pendentes'];
		}

		$this->Publicacao->recursive = 1;
		$this->set('publicacoes', $this->paginate('Publicacao', $condicoes));
		$this->set('despachos', $this->Publicacao->Despacho->find('list'));
		$this->set('status', $this->Publicacao->Tecnologia->Status->find('list'));
		$this->set('colunas', $this->Publicacao->CamposExportacao());
		$this->data = $data;

		$publicacoes = $this->Publicacao->find('all', array('conditions'=>$condicoes));
		$ids = Set::extract($publicacoes, "{n}.Publicacao.id");
		$this->set('ids',json_encode($ids));
	}

	function exportar(){
		set_time_limit(300);
		$this->autoRender = false;

		//$inventores_key = array_search('inventores', $_POST['fields']);
		//if($inventores_key){
		//	$tem_inventores = true;
		//	unset($_POST['fields'][$inventores_key]);
		//}
		//
		//$titulares_key = array_search('titulares', $_POST['fields']);
		//if($titulares_key){
		//	$tem_titulares = true;
		//	unset($_POST['fields'][$titulares_key]);
		//}
		//	
		//$ultimo_despacho_key = array_search('ultimo_despacho', $_POST['fields']);
		//if($ultimo_despacho_key){
		//	$tem_ultimo_despacho = true;
		//	unset($_POST['fields'][$ultimo_despacho_key]);
		//}

		$publicacoes = $this->Publicacao->find('all',array(
			'conditions' => array('Publicacao.id' => $_POST['ids'])
		));

		$colunas = $this->Publicacao->CamposExportacao();
		//print_r($publicacoes);
		//print_r($_POST['fields']);
		//exit();

		//Cria a planilha
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		
		//Cria o cabeçalho
		for ($i=1; $i <= count($_POST['fields']) ; $i++) { 
			$sheet->getCellByColumnAndRow($i,1)->setValue($colunas[$_POST['fields'][$i-1]]['label']);
			$sheet->getStyle($sheet->getCellByColumnAndRow($i,1)->getCoordinate())->getFont()->setBold( true );	
			if(isset($colunas[$_POST['fields'][$i-1]]['width']))
				$sheet->getColumnDimensionByColumn($i)->setWidth($colunas[$_POST['fields'][$i-1]]['width']);
		}
		//if(isset($tem_ultimo_despacho)){
		//	$cell = $sheet->getCellByColumnAndRow($i++,1);
		//	$cell->setValue("Último Despacho");
		//	$sheet->getStyle($cell->getCoordinate())->getFont()->setBold(true);	
		//	$sheet->getColumnDimensionByColumn($i-1)->setWidth(25);
		//}
		//if(isset($tem_inventores )){
		//	$cell = $sheet->getCellByColumnAndRow($i++,1);
		//	$cell->setValue("Inventores");
		//	$sheet->getStyle($cell->getCoordinate())->getFont()->setBold(true);	
		//	$sheet->getColumnDimensionByColumn($i-1)->setWidth(50);
		//}
		//if(isset($tem_titulares)){
		//	$cell = $sheet->getCellByColumnAndRow($i++,1);
		//	$cell->setValue("Titulares");
		//	$sheet->getStyle($cell->getCoordinate())->getFont()->setBold(true);	
		//	$sheet->getColumnDimensionByColumn($i-1)->setWidth(25);
		//}
		//
		//$andamentos = $this->Tecnologia->Andamento->find('list');
		//$status_transferencia = $this->Tecnologia->StatusTransferencia->find('list');
		//
		//$andamentos[0] = $status_transferencia[0] = "";
		//$andamentos[NULL] = $status_transferencia[NULL] = "";
		//
		$lineNumber = 1;
		foreach ($publicacoes as $key => $publicacao) {
			$lineNumber++;
			for ($i=1; $i <= count($_POST['fields']) ; $i++) {
				switch ($_POST['fields'][$i-1]) {
					case 'pasta':
						$cellValue = $publicacao['Tecnologia']['pasta'];
						break;
					case 'despacho':
						$cellValue = $publicacao['Despacho']['codigo'].' - '.$publicacao['Despacho']['titulo'];
						break;
					case 'tecnologia':
						$cellValue = $publicacao['Tecnologia']['num_pedido'];
						break;
					case 'status':
						$status_providencias = [''=>'-',1 => '-', 2 => 'Pendente', 3 => 'Cumprida'];
						$cellValue = $status_providencias[$publicacao['Publicacao']['status_providencia_id']];
						break;
					case 'prazo':
						$cellValue = $publicacao['Publicacao']['prazo'] == '0000-00-00' ? '' : $publicacao['Publicacao']['prazo'];
						break;
					default:
						$cellValue = $publicacao['Publicacao'][$_POST['fields'][$i-1]];
						break;
				}
				$sheet->getCellByColumnAndRow($i,$lineNumber)->setValue($cellValue);	
				$sheet->getStyle($sheet->getCellByColumnAndRow($i,$lineNumber)->getCoordinate())->getAlignment()->setWrapText(true);
				$sheet->getStyle($sheet->getCellByColumnAndRow($i,$lineNumber)->getCoordinate())->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
			}
			//if(isset($tem_ultimo_despacho)){
			//	$count = count($tecnologia['Publicacao']);
			//	if($count > 0)
			//	{
			//		$sheet->getCellByColumnAndRow($i++,$lineNumber)->setValue('"'.$tecnologia['Publicacao'][0]['codigo_despacho'].'"');
			//	}
			//	else{
			//		$sheet->getCellByColumnAndRow($i++,$lineNumber)->setValue('');
			//	}
			//	$sheet->getStyle($sheet->getCellByColumnAndRow($i-1,$lineNumber)->getCoordinate())->getAlignment()->setWrapText(true);
			//	$sheet->getStyle($sheet->getCellByColumnAndRow($i-1,$lineNumber)->getCoordinate())->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
			//}
			//if(isset($tem_inventores)){
			//	$inventores = "";
			//	foreach ($tecnologia['Inventor'] as $key => $inventor) {
			//		if($key == 0){
			//			$inventores = $inventor['nome'];
			//		}else{
			//			$inventores = $inventores."\n".$inventor['nome'];
			//		}
			//	}
			//	$sheet->getCellByColumnAndRow($i++,$lineNumber)->setValue($inventores);
			//	$sheet->getStyle($sheet->getCellByColumnAndRow($i-1,$lineNumber)->getCoordinate())->getAlignment()->setWrapText(true);
			//	$sheet->getStyle($sheet->getCellByColumnAndRow($i-1,$lineNumber)->getCoordinate())->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
			//}
			//if(isset($tem_titulares)){
			//	$titulares = "";
			//	foreach ($tecnologia['Titular'] as $key => $titular) {
			//		if($key == 0){
			//			$titulares = $titular['nome'];
			//		}else{
			//			$titulares = $titulares."\n".$titular['nome'];
			//		}			
			//	}
			//	$sheet->getCellByColumnAndRow($i++,$lineNumber)->setValue($titulares);
			//	$sheet->getStyle($sheet->getCellByColumnAndRow($i-1,$lineNumber)->getCoordinate())->getAlignment()->setWrapText(true);
			//	$sheet->getStyle($sheet->getCellByColumnAndRow($i-1,$lineNumber)->getCoordinate())->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
			//}
		}

		$writer = new Xlsx($spreadsheet);

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
	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid area', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Publicacao->recursive = 2;
		
		$publicacao = $this->Publicacao->findById($id);
		// debug($inventor);
		$this->set('publicacao',$publicacao);
	}

	function add() {
		if (!empty($this->data)) {
			$this->Area->create();
			if ($this->Area->save($this->data)) {
				$this->Session->setFlash(__('The area has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The area could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid area', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Publicacao->save($this->data)) {
				$this->Session->setFlash(__('The area has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The area could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Publicacao->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for area', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Area->delete($id)) {
			$this->Session->setFlash(__('Area deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Area was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

	function cumprir($id) {
		$publicacao = $this->Publicacao->findById($id);
		$publicacao['Publicacao']['status_providencia_id'] = 3;
		$publicacao['Publicacao']['cumprida_em'] = date("Y-m-d H:i:s");
		$this->Publicacao->save($publicacao);
		$this->redirect(array('controller'=>'rpis','action' => 'view', $publicacao['Publicacao']['num_rpi']));
	}

	function cumprir_lote() {
		$this->autoRender = false;
		$ids = explode(',', $_POST['ids']);

		foreach ($ids as $key => $id) {
			$publicacao = $this->Publicacao->findById($id);
			$publicacao['Publicacao']['status_providencia_id'] = 3;
			$publicacao['Publicacao']['cumprida_em'] = date("Y-m-d H:i:s");
			$this->Publicacao->save($publicacao);
		}
	}
}
?>