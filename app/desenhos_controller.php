<?php
require 'vendors/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class DesenhosController extends AppController {

	var $name = 'Desenhos';
	var $components = array('Upload');

	function index() {
		$this->Desenho->recursive = 0;
		$this->set('desenhos', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid desenho', true));
			$this->redirect(array('action' => 'index'));
		}

		$this->Desenho->recursive = 1;
		$desenho = $this->Desenho->read(null, $id);
		$this->set('desenho', $desenho);
	}

	function add() {
		if (!empty($this->data)) {
			$this->Desenho->create();
			if ($this->Desenho->save($this->data)) {
				$this->Session->setFlash(__('The desenho has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The desenho could not be saved. Please, try again.', true));
			}
		}
		$areas = $this->Desenho->Area->find('list');
		$andamentos = $this->Desenho->Andamento->find('list');
		$status = $this->Desenho->Status->find('list');
		$departamentos = $this->Desenho->Departamento->find('list');
		$inventores = $this->Desenho->Inventor->find('list');
		$titulares = $this->Desenho->Titular->find('list');
		$redatores = $this->Desenho->Redator->find('list', array('order' => 'nome ASC'));
		$this->set(compact('areas', 'andamentos', 'redatores', 'status', 'departamentos', 'inventores', 'titulares'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid desenho', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Desenho->save($this->data)) {
				$this->Session->setFlash(__('The desenho has been saved', true));
				$this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(__('The desenho could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Desenho->read(null, $id);
			$arquivos = $this->data['Arquivo'];
		}

		$desenho = $this->Desenho->read(null, $id);
		$areas = $this->Desenho->Area->find('list');
		$andamentos = $this->Desenho->Andamento->find('list');
		$status = $this->Desenho->Status->find('list');
		$unidades = $this->Desenho->Unidade->find('list');
		$departamentos = $desenho['Departamento'];
		$inventores = $desenho['Inventor'];
		$titulares = $desenho['Titular'];
		$empresas = $desenho['Empresa'];
		$redatores = $this->Desenho->Redator->find('list', array('order' => 'nome ASC'));

		$desenho_id = $id; // envia o ID da tecnologia para o view permitindo o acesso via JS

		$this->set(compact('unidades','redatores', 'desenho_id','areas', 'andamentos', 'status', 'departamentos', 'inventores', 'titulares','empresas','arquivos'));
	}

	function search() {		
		// se houve uma busca
		if (!empty($this->data)) {
			//debug($this->data);
			//exit();
			
			$condicoes = array(); // armazena as condicoes da busca
			$options   = array(); // será passada para a funcao 
		
			$titulo      = $this->data['Desenho']['titulo'];
			$num_pedido  = $this->data['Desenho']['num_pedido'];
			$pasta       = $this->data['Desenho']['pasta'];
			$pasta_juridico = $this->data['Desenho']['pasta_juridico'];
			$anoDe       = $this->data['Desenho']['desde'];
			$anoAte      = $this->data['Desenho']['ate'];
			$redator_id 	 = $this->data['Desenho']['redator_id'];
			$num_processo_sei 	 = $this->data['Desenho']['num_processo_sei'];
			$andamento_id = $this->data['Desenho']['andamento_id'];
			$status_id   = $this->data['Desenho']['status_id'];
		
			if (!empty($titulo)) {
				$condicoes['Desenho.titulo LIKE'] = '%'.$titulo.'%';
			}
		
			if (!empty($num_pedido)) {
				$condicoes['Desenho.num_pedido LIKE'] = '%'.$num_pedido.'%';
			}
			
			if (!empty($pasta)) {
				$condicoes['Desenho.pasta LIKE'] = '%'.$pasta.'%';
			}

			if (!empty($num_processo_sei)) {
				$condicoes['Desenho.num_processo_sei LIKE'] = '%'.$num_processo_sei.'%';
			}

			if (!empty($pasta_juridico)) {
				$condicoes['Desenho.pasta_juridico LIKE'] = '%'.$pasta_juridico.'%';
			}

			if (!empty($redator_id)) {
				$condicoes['Desenho.redator_id LIKE'] = '%'.$redator_id.'%';
			}

			if (!empty($andamento_id)) {
				$condicoes['Desenho.andamento_id LIKE'] = '%'.$andamento_id.'%';
			}

			if (!empty($status_id)) {
				$condicoes['Desenho.status_id LIKE'] = '%'.$status_id.'%';
			}
		
			if (!empty($anoDe) && !empty($anoAte)) {
				$condicoes['YEAR(Desenho.data) >='] = $anoDe;
				$condicoes['YEAR(Desenho.data) <='] = $anoAte;
			} elseif (!empty($anoDe) && empty($anoAte)) {
				$condicoes['YEAR(Desenho.data) >='] = $anoDe;
			}	elseif (empty($anoDe) && !empty($anoAte)) {
					$condicoes['YEAR(Desenho.data) <='] = $anoAte;
				}

	
			$options['order'] = array(
			'Desenho.data' => 'desc',
					'Desenho.num_pedido' => 'desc'
			);
	
			$options['conditions'] = $condicoes;
			$desenhos = $this->Desenho->find('all', $options );
			$this->set('desenhos',$desenhos);

			$ids = Set::extract($desenhos, "{n}.Desenho.id");
			$this->set('ids',json_encode($ids));
		}
		
		// ANOS //
		$params = array(
			'fields'=>array('DISTINCT(YEAR(Desenho.data)) as ano'),
			'order' => array('Desenho.data ASC'),
			'recursive' => 0
		);
		
		$anosTmp = $this->Desenho->find('all', $params);
		$anos = array();
		
		for ($i=0; $i < count($anosTmp); $i++) {
			$anos[$anosTmp[$i][0]['ano']] = $anosTmp[$i][0]['ano'];
		}
		$desdes = $ates = $anos;
		$redatores = $this->Desenho->Redator->find('list', array('order' => 'nome ASC'));
		$andamentos = $this->Desenho->Andamento->find('list');
		$status = $this->Desenho->Status->find('list');
		$colunas = $this->Desenho->CamposExportacao();

		$this->set(compact('desdes', 'ates','redatores','andamentos','status','colunas'));
	}

	function exportar(){
		set_time_limit(300);
		$this->autoRender = false;

		$inventores_key = array_search('inventores', $_POST['fields']);
		if($inventores_key){
			$tem_inventores = true;
			unset($_POST['fields'][$inventores_key]);
		}

		$titulares_key = array_search('titulares', $_POST['fields']);
		if($titulares_key){
			$tem_titulares = true;
			unset($_POST['fields'][$titulares_key]);
		}

		$desenhos = $this->Desenho->find('all',array(
			'conditions' => array('Desenho.id' => $_POST['ids']),
			'fields' => $_POST['fields']
		));

		$colunas = $this->Desenho->CamposExportacao();

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

		$andamentos = $this->Desenho->Andamento->find('list');
		//$status_transferencia = $this->Desenho->StatusTransferencia->find('list');

		//$andamentos[0] = $status_transferencia[0] = "";
		//$andamentos[NULL] = $status_transferencia[NULL] = "";

		$lineNumber = 1;
		foreach ($desenhos as $key => $desenho) {
			$lineNumber++;
			for ($i=1; $i <= count($_POST['fields']) ; $i++) {
				switch ($_POST['fields'][$i-1]) {
					case 'andamento_id':
						$cellValue = $andamentos[$desenho['Desenho'][$_POST['fields'][$i-1]]];
						break;
					//case 'status_transferencia_id':
					//	$cellValue = $status_transferencia[$desenho['Desenho'][$_POST['fields'][$i-1]]];
					//	break;
					default:
						$cellValue = $desenho['Desenho'][$_POST['fields'][$i-1]];
						break;
				}
				$sheet->getCellByColumnAndRow($i,$lineNumber)->setValue($cellValue);	
				$sheet->getStyle($sheet->getCellByColumnAndRow($i,$lineNumber)->getCoordinate())->getAlignment()->setWrapText(true);
				$sheet->getStyle($sheet->getCellByColumnAndRow($i,$lineNumber)->getCoordinate())->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
			}
			if(isset($tem_inventores)){
				$inventores = "";
				foreach ($desenho['Inventor'] as $key => $inventor) {
					if($key == 0){
						$inventores = $inventor['nome'];
					}else{
						$inventores = $inventores."\n".$inventor['nome'];
					}
				}
				$sheet->getCellByColumnAndRow($i++,$lineNumber)->setValue($inventores);
				$sheet->getStyle($sheet->getCellByColumnAndRow($i-1,$lineNumber)->getCoordinate())->getAlignment()->setWrapText(true);
				$sheet->getStyle($sheet->getCellByColumnAndRow($i-1,$lineNumber)->getCoordinate())->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
			}
			if(isset($tem_titulares)){
				$titulares = "";
				foreach ($desenho['Titular'] as $key => $titular) {
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

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for desenho', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Desenho->delete($id)) {
			$this->Session->setFlash(__('Desenho deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Desenho was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

	function desassociarInventor($idTec = null, $idInventor = null) {
		if (!$idTec || !$idInventor) {
			$this->Session->setFlash(__('Invalid tecnologia', true));
			$this->redirect(array('action' => 'index'));
		}
		
		$query = sprintf("DELETE FROM desenhos_inventores WHERE desenho_id = %d AND inventor_id = %d LIMIT 1", $idTec, $idInventor);
		$resultado = $this->Desenho->query($query);
				
		$this->Session->setFlash(__('Inventor desassociado com sucesso', true));
		$this->redirect(array('action' => 'view', $idTec));
	}

	function ajaxListarInventores() {
		//Configure::write('debug', 0);
				
		$nome = $_GET['term'];
				
		$params = array(
			'fields'=>array('id','nome'),
			'order' => array('Inventor.nome ASC'),
			'conditions' => array('Inventor.nome LIKE' => $nome.'%'),
			'recursive' => 0
		);
		
		$inventores = $this->Desenho->Inventor->find('list', $params);
		$this->layout = '';
		$this->set('inventores', $inventores);		
	}//ajaxListarInventores

	function ajaxDesassociarInventor() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$inventor_id = $_GET['id'];
		$desenho_id = $_GET['tec_id'];
		
		$query = sprintf("DELETE FROM desenhos_inventores WHERE desenho_id = %d AND inventor_id = %d LIMIT 1", $desenho_id, $inventor_id);
		$resultado = $this->Desenho->query($query);
		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Inventor desassociado com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao desassociar este inventor. Saia do sistema e tente novamente.", true) );
		}
		
	}//ajaxDesassociarInventor

	function ajaxListarTitulares() {
		Configure::write('debug', 0);
				
		$nome = $_GET['term'];
				
		$params = array(
			'fields'=>array('id','nome'),
			'order' => array('Titular.nome ASC'),
			'conditions' => array('Titular.nome LIKE' => $nome.'%'),
			'recursive' => 0
		);
		
		$titulares = $this->Desenho->Titular->find('list', $params);
		$this->layout = '';
		$this->set('titulares', $titulares);		
	}//ajaxListarTitulares

	function ajaxAssociarTitular() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$titular_id = $_GET['id'];
		$desenho_id = $_GET['tec_id'];
		
		// checa para ver se este autor já não está associado a esta tecnologia antes
		$query = sprintf("
		SELECT * FROM desenhos_titulares 
		WHERE desenho_id=%d AND titular_id=%d
		LIMIT 1", 
		$desenho_id, $titular_id);
		$resultado = $this->Desenho->query($query);

		if ( count($resultado) ) {
			// houve resultado na busca, indicando que tentou-se repetir uma associação
			// retorna um JSON com o erro
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __($query, true) );
			exit;
		}
		
		$query = sprintf("
		INSERT INTO desenhos_titulares (
			desenho_id,
			titular_id
		) VALUES (%d, %d)", 
		$desenho_id, $titular_id );
		$resultado = $this->Desenho->query($query);

		
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
		$desenho_id = $_GET['tec_id'];
		
		$query = sprintf("DELETE FROM desenhos_titulares WHERE desenho_id = %d AND titular_id = %d LIMIT 1", $desenho_id, $titular_id);
		$resultado = $this->Desenho->query($query);
		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Titular desassociado com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao desassociar este inventor. Saia do sistema e tente novamente.", true) );
		}
		
	}//ajaxDesassociarTitular

	function ajaxListarDepartamentos() {
		Configure::write('debug', 0);
				
		$nome = $_GET['term'];
				
		$params = array(
			'fields'=>array('id','nome','Unidade.id','Unidade.nome'),
			'order' => array('Departamento.nome ASC'),
			'conditions' => array(
								'OR'=>array(
										'Departamento.nome LIKE' => '%'.$nome.'%',
										'Unidade.nome LIKE' => '%'.$nome.'%',
								)
							),
			'recursive' => 0
		);
		
		$departamentos = $this->Desenho->Departamento->find('all', $params);
		$this->layout = '';
		$this->set('departamentos', $departamentos);	
	}//ajaxListarDepartamentos


	function ajaxAssociarDepartamento() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$departamento_id = $_GET['id'];
		$unidade_id = $_GET['uni_id'];
		$desenho_id = $_GET['tec_id'];
		
		// checa para ver se este autor já não está associado a esta tecnologia antes
		$query = sprintf("
		SELECT * FROM departamentos_desenhos 
		WHERE departamento_id=%d AND desenho_id=%d
		LIMIT 1", 
		$departamento_id, $desenho_id );
		$resultado = $this->Desenho->query($query);

		if ( count($resultado) ) {
			// houve resultado na busca, indicando que tentou-se repetir uma associação
			// retorna um JSON com o erro
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __($query, true) );
			exit;
		}
		
		$query = sprintf("
		INSERT INTO departamentos_desenhos (
			desenho_id,
			departamento_id,
			unidade_id
		) VALUES (%d, %d, %d)", 
		$desenho_id, $departamento_id, $unidade_id);
		$resultado = $this->Desenho->query($query);

		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Origem associada com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __($query, true) );
		}
		
	}//ajaxAssociarTitular

	function ajaxDesassociarDepartamento() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$departamento_id = $_GET['id'];
		$desenho_id = $_GET['tec_id'];
		
		$query = sprintf("DELETE FROM departamentos_desenhos WHERE desenho_id = %d AND departamento_id = %d LIMIT 1", $desenho_id, $departamento_id);
		$resultado = $this->Desenho->query($query);
		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Departamento desassociado com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao desassociar este departamento. Saia do sistema e tente novamente.", true) );
		}
		
	}//ajaxDesassociarDepartamento
	
	function ajaxAssociarInventor() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$inventor_id = $_GET['id'];
		$desenho_id = $_GET['tec_id'];
		
		// checa para ver se este autor já não está associado a esta tecnologia antes
		$query = sprintf("
		SELECT * FROM desenhos_inventores
		WHERE inventor_id=%d AND desenho_id=%d
		LIMIT 1", 
		$inventor_id, $desenho_id );
		$resultado = $this->Desenho->query($query);
		
		if ( count($resultado) ) {
			// houve resultado na busca, indicando que tentou-se repetir uma associação
			// retorna um JSON com o erro
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Este inventor já está associado com este desenho industrial.", true) );
			exit;
	}
		
		$query = sprintf("
		INSERT INTO desenhos_inventores (
			desenho_id,
			inventor_id			
		) VALUES (%d, %d)", 
		$desenho_id, $inventor_id);
		$resultado = $this->Desenho->query($query);
		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Inventor associado com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao associar este inventor. Saia do sistema e tente novamente.", true) );
		}
		
	}//ajaxAssociarInventor

	function ajaxAdicionarArquivos($id = null) {
		// Reference general return: printf(json_encode(var_export($this->data, true)));exit;
		Configure::write('debug', 0);
		$this->autoRender = false;

		if ( empty($this->data) /*|| empty($this->data['Tecnologia']['arquivo']['tmp_name'])*/ ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, 'Favor enviar um arquivo.');exit;
		}

		// initialize the upload object
		$this->Upload->upload($this->data['Desenho']['arquivo'] );


		$uuid = String::uuid();
		$filename = $uuid;
		
		$nomeOriginal = $this->data['Desenho']['arquivo']['name'];
		$mimetype     = $this->data['Desenho']['arquivo']['type'];

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
		$saving['Arquivo']['desenho_id'] = $id;
		$saving['Arquivo']['mimetype']      = $mimetype;
		$this->Desenho->Arquivo->create();
		$this->Desenho->Arquivo->save($saving);

		printf('{"sucesso":%d, "nomeOriginal":"%s", "id":"%s"}', 1, $nomeOriginal, $filename);
	}
}
