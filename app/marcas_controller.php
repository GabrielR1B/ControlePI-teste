<?php
require 'vendors/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class MarcasController extends AppController {

	var $name = 'Marcas';
	var $components = array('Upload');
	
	var $paginate = array(
		'limit' => 100,
		'order' => array(
			'Marca.data' => 'desc'
		)
	);



	function index() {
		$this->Marca->recursive = 1;
		$marcas = $this->paginate();
		// debug($marcas);
		$this->set('marcas', $marcas);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid marca', true));
			$this->redirect(array('action' => 'index'));
		}
		$marca = $this->Marca->read(null, $id);
		// debug($marca);
		$this->set('marca', $marca);
	}

	function add() {
		if (!empty($this->data)) {
			$this->Marca->create();
			if ($this->Marca->save($this->data)) {
				$this->Session->setFlash(__('The marca has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The marca could not be saved. Please, try again.', true));
			}
		}

		$naturezamarcas = $this->Marca->NaturezaMarca->find('list');
		$apresentacoes = $this->Marca->Apresentacao->find('list');
		$andamentos  = $this->Marca->Andamento->find('list');
		$status  = $this->Marca->Status->find('list');

		$this->set(compact('naturezamarcas','apresentacoes','andamentos','status'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for marca', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Marca->delete($id, true)) {
			$this->Session->setFlash(__('Marca deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Marca was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

	function edit($id = null) {		
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid marca', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Marca->save($this->data)) {
				$this->Session->setFlash(__('The marca has been saved', true));
				$this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(__('The marca could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Marca->read(null, $id);
			$arquivos = $this->data['Arquivo'];
		}

		$marca = $this->Marca->read(null, $id);
		// print_r($marca);exit;
		// busca os inventores associados a marca em edição
	
		
		$naturezamarcas = $this->Marca->NaturezaMarca->find('list'); 			// pega as áreas para popular o select
		$apresentacoes  = $this->Marca->Apresentacao->find('list');	// pega as situacoes para popular o select	
		$andamentos  = $this->Marca->Andamento->find('list');
		$status  = $this->Marca->Status->find('list');
		$marca_id = $id; // envia o ID da marca para o view permitindo o acesso via JS

		$this->set(compact('marca','naturezamarcas', 'apresentacoes', 'marca_id','andamentos','status','arquivos'));
	}

	function search() {		
		// se houve uma busca
		if (!empty($this->data)) {
			// debug($this->data);
			
			$condicoes = array(); // armazena as condicoes da busca
			$options   = array(); // será passada para a funcao 
		
			$nome      = $this->data['Marca']['nome'];
			$processo    = $this->data['Marca']['processo'];
			$pasta       = $this->data['Marca']['pasta'];
			$pasta_juridico = $this->data['Marca']['pasta_juridico'];
			$num_processo_sei = $this->data['Marca']['num_processo_sei'];
			$anoDe       = $this->data['Marca']['desde'];
			$anoAte      = $this->data['Marca']['ate'];
		
			if (!empty($nome)) {
				$condicoes['Marca.nome LIKE'] = '%'.$nome.'%';
			}
		
			if (!empty($processo)) {
				$condicoes['Marca.processo LIKE'] = '%'.$processo.'%';
			}
			
			if (!empty($pasta)) {
				$condicoes['Marca.pasta LIKE'] = '%'.$pasta.'%';
			}	

			if (!empty($pasta_juridico)) {
				$condicoes['Marca.pasta_juridico LIKE'] = '%'.$pasta_juridico.'%';
			}

			if (!empty($num_processo_sei)) {
				$condicoes['Marca.num_processo_sei LIKE'] = '%'.$num_processo_sei.'%';
			}			
		
			if (!empty($anoDe) && !empty($anoAte)) {
				$condicoes['YEAR(Marca.data) >='] = $anoDe;
				$condicoes['YEAR(Marca.data) <='] = $anoAte;
			} elseif (!empty($anoDe) && empty($anoAte)) {
				$condicoes['YEAR(Marca.data) >='] = $anoDe;
			}	elseif (empty($anoDe) && !empty($anoAte)) {
					$condicoes['YEAR(Marca.data) <='] = $anoAte;
				}

	
			$options['order'] = array(
			'Marca.data' => 'desc',
					'Marca.processo' => 'desc'
			);
	
			$options['conditions'] = $condicoes;
			$marcas = $this->Marca->find('all', $options );
			$this->set('marcas',$marcas);

			$ids = Set::extract($marcas, "{n}.Marca.id");
			$this->set('ids',json_encode($ids));
		}
		
		// ANOS //
		$params = array(
			'fields'=>array('DISTINCT(YEAR(Marca.data)) as ano'),
			'order' => array('Marca.data ASC'),
			'recursive' => 0
		);
		
		$anosTmp = $this->Marca->find('all', $params);
		$anos = array();
		
		for ($i=0; $i < count($anosTmp); $i++) {
			$anos[$anosTmp[$i][0]['ano']] = $anosTmp[$i][0]['ano'];
		}
		$desdes = $ates = $anos;
		$colunas = $this->Marca->CamposExportacao();

		$this->set(compact('desdes', 'ates', 'colunas'));
	}

	function exportar(){
		Configure::write('debug', 0);
		set_time_limit(300);
		$this->autoRender = false;

		$titulares_key = array_search('titulares', $_POST['fields']);
		if($titulares_key){
			$tem_titulares = true;
			unset($_POST['fields'][$titulares_key]);
		}

		$marcas = $this->Marca->find('all',array(
			'conditions' => array('Marca.id' => $_POST['ids']),
			'fields' => $_POST['fields']
		));

		$colunas = $this->Marca->CamposExportacao();

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
		if(isset($tem_inventores )){
			$cell = $sheet->getCellByColumnAndRow($i++,1);
			$cell->setValue("Inventores");
			$sheet->getStyle($cell->getCoordinate())->getFont()->setBold(true);	
			$sheet->getColumnDimensionByColumn($i-1)->setWidth(50);
		}
		if(isset($tem_titulares)){
			$cell = $sheet->getCellByColumnAndRow($i++,1);
			$cell->setValue("Titulares");
			$sheet->getStyle($cell->getCoordinate())->getFont()->setBold(true);	
			$sheet->getColumnDimensionByColumn($i-1)->setWidth(25);
		}

		$andamentos = $this->Marca->Andamento->find('list');
		//$status_transferencia = $this->Desenho->StatusTransferencia->find('list');

		//$andamentos[0] = $status_transferencia[0] = "";
		//$andamentos[NULL] = $status_transferencia[NULL] = "";

		$lineNumber = 1;
		foreach ($marcas as $key => $marca) {
			$lineNumber++;
			for ($i=1; $i <= count($_POST['fields']) ; $i++) {
				switch ($_POST['fields'][$i-1]) {
					case 'andamento_id':
						$cellValue = $andamentos[$marca['Marca'][$_POST['fields'][$i-1]]];
						break;
					default:
						$cellValue = $marca['Marca'][$_POST['fields'][$i-1]];
						break;
				}
				$sheet->getCellByColumnAndRow($i,$lineNumber)->setValue($cellValue);	
				$sheet->getStyle($sheet->getCellByColumnAndRow($i,$lineNumber)->getCoordinate())->getAlignment()->setWrapText(true);
				$sheet->getStyle($sheet->getCellByColumnAndRow($i,$lineNumber)->getCoordinate())->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
			}
			if(isset($tem_titulares)){
				$titulares = "";
				foreach ($marca['Titular'] as $key => $titular) {
					if($key == 0){
						$titulares = $titular['nome'];
					}else{
						$titulares = $titulares."\n".$titular['nome'];
					}			
				}
				$sheet->getCellByColumnAndRow($i++,$lineNumber)->setValue($titulares);
				$sheet->getStyle($sheet->getCellByColumnAndRow($i-1,$lineNumber)->getCoordinate())->getAlignment()->setWrapText(true);
				$sheet->getStyle($sheet->getCellByColumnAndRow($i-1,$lineNumber)->getCoordinate())->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
			}
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

	function ajaxAssociarTitular() {
		//Configure::write('debug', 0);
		$this->autoRender = false;
		
		$titular_id = $_GET['id'];
		$marca_id = $_GET['marca_id'];
		
		// checa para ver se este autor já não está associado a esta marca antes
		$query = sprintf("
		SELECT * FROM marcas_titulares 
		WHERE titular_id=%d AND marca_id=%d
		LIMIT 1", 
		$titular_id, $marca_id );
		$resultado = $this->Marca->query($query);

		if ( count($resultado) ) {
			// houve resultado na busca, indicando que tentou-se repetir uma associação
			// retorna um JSON com o erro
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __($query, true) );
			exit;
		}
		
		$query = sprintf("
		INSERT INTO marcas_titulares (
			marca_id,
			titular_id
		) VALUES (%d, %d)", 
		$marca_id, $titular_id );
		$resultado = $this->Marca->query($query);

		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Titular associado com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __($query, true) );
		}
		
	}//ajaxAssociarTitular

	function ajaxDesassociarTitular() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$titular_id = $_GET['id'];
		$marca_id = $_GET['marca_id'];
		
		$query = sprintf("DELETE FROM marcas_titulares WHERE marca_id = %d AND titular_id = %d LIMIT 1", $marca_id, $titular_id);
		$resultado = $this->Marca->query($query);
		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Titular desassociado com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao desassociar este inventor. Saia do sistema e tente novamente.", true) );
		}
	}//ajaxDesassociarTitular

	function ajaxAssociarInventor() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$inventor_id = $_GET['id'];
		$marca_id = $_GET['marca_id'];
		
		// checa para ver se este autor já não está associado a esta marca antes
		$query = sprintf("
		SELECT * FROM inventores_marcas 
		WHERE inventor_id=%d AND marca_id=%d
		LIMIT 1", 
		$inventor_id, $marca_id );
		$resultado = $this->Marca->query($query);
		
		if ( count($resultado) ) {
			// houve resultado na busca, indicando que tentou-se repetir uma associação retorna um JSON com o erro
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Este inventor já está associado com esta marca.", true) );
			exit;
		}
		
		$query = sprintf("
		INSERT INTO inventores_marcas (inventor_id,marca_id) VALUES (%d, %d)", $inventor_id, $marca_id );
		$resultado = $this->Marca->query($query);
		
		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Inventor associado com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao associar este inventor. Saia do sistema e tente novamente.", true) );
		}
		
	}//ajaxAssociarInventor

	function ajaxDesassociarInventor() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$inventor_id = $_GET['id'];
		$marca_id = $_GET['marca_id'];
		
		$query = sprintf("DELETE FROM inventores_marcas WHERE marca_id = %d AND inventor_id = %d LIMIT 1", $marca_id, $inventor_id);
		$resultado = $this->Marca->query($query);
		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Inventor desassociado com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao desassociar este inventor. Saia do sistema e tente novamente.", true) );
		}	
	}//ajaxDesassociarInventor

	function ajaxAdicionarArquivos($id = null) {
		// Reference general return: printf(json_encode(var_export($this->data, true)));exit;
		Configure::write('debug', 0);
		$this->autoRender = false;

		if ( empty($this->data) /*|| empty($this->data['Tecnologia']['arquivo']['tmp_name'])*/ ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, 'Favor enviar um arquivo.');exit;
		}

		// initialize the upload object
		$this->Upload->upload( $this->data['Marca']['arquivo'] );


		$uuid = String::uuid();
		$filename = $uuid;
		
		$nomeOriginal = $this->data['Marca']['arquivo']['name'];
		$mimetype     = $this->data['Marca']['arquivo']['type'];

		$this->Upload->file_new_name_body = $filename;
		$this->Upload->file_safe_name     = false;
		$this->Upload->file_auto_rename   = false;
		$this->Upload->file_overwrite     = true;
		$this->Upload->Process(PATH_ARQUIVOS); 

		if (!$this->Upload->processed) {
			$this->Upload->clean();
			printf('{"sucesso":%d, "retorno":"%s"}', 0, 'Não foi possível adicionar o arquivo: ' . $this->Upload->error );
			exit;
		}

		$saved_filename = $this->Upload->file_dst_name;

		// Clean the temp files generated by the upload class
		$this->Upload->clean();

		// Save to database
		$saving                             = array();
		$saving['Arquivo']['id']            = $filename;
		$saving['Arquivo']['nomedisco']     = $saved_filename;
		$saving['Arquivo']['nomeoriginal']  = $nomeOriginal;
		$saving['Arquivo']['marca_id'] = $id;
		$saving['Arquivo']['mimetype']      = $mimetype;
		$this->Marca->Arquivo->create();
		$this->Marca->Arquivo->save($saving);

		printf('{"sucesso":%d, "nomeOriginal":"%s", "id":"%s"}', 1, $nomeOriginal, $filename);exit;
	}
}
?>