<?php
class SoftwaresController extends AppController {

	var $name = 'Softwares';
	var $components = array('Upload');

	function index() {
		$this->Software->recursive = 0;
		$this->set('softwares', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid software', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('software', $this->Software->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Software->create();
			if ($this->Software->save($this->data)) {
				$this->Session->setFlash(__('The software has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The software could not be saved. Please, try again.', true));
			}
		}
		
		$status = $this->Software->Status->find('list');
		$departamentos = $this->Software->Departamento->find('list');
		$inventores = $this->Software->Inventor->find('list');
		$titulares = $this->Software->Titular->find('list');
		$this->set(compact('status', 'departamentos', 'inventores', 'titulares'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid software', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Software->save($this->data)) {
				$this->Session->setFlash(__('The software has been saved', true));
				$this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(__('The software could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Software->read(null, $id);
			$arquivos = $this->data['Arquivo'];
		}
		
		$software = $this->Software->read(null, $id);
		$departamentos = $software['Departamento'];
		$inventores = $software['Inventor'];
		$titulares = $software['Titular'];
		$empresas = $software['Empresa'];
		$unidades = $this->Software->Unidade->find('list');
		$status = $this->Software->Status->find('list');
		$software_id = $id; // envia o ID do software para o view permitindo o acesso via JS

		$this->set(compact('status', 'departamentos', 'inventores', 'empresas', 'titulares', 'software_id', 'unidades', 'arquivos'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for software', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Software->delete($id)) {
			$this->Session->setFlash(__('Software deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Software was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

	function search(){

		if (!empty($this->data)) {

			$condicoes = array(); // armazena as condicoes da busca
			$options   = array(); // será passada para a funcao 

			$titulo      = $this->data['Software']['titulo'];
			$num_pedido  = $this->data['Software']['num_pedido'];
			$pasta       = $this->data['Software']['pasta'];
			$pasta_juridico = $this->data['Software']['pasta_juridico'];
			$num_processo_sei = $this->data['Software']['num_processo_sei'];
			$unidade_id  = $this->data['Software']['unidade_id'];
			$inventor_id = $this->data['Inventor']['Inventor'];
			$status_id   = $this->data['Software']['status_id'];
			$anoDe       = $this->data['Software']['desde'];
			$anoAte      = $this->data['Software']['ate'];

			if (!empty($titulo)) {
				$condicoes['Software.titulo LIKE'] = '%'.$titulo.'%';
			}
		
			if (!empty($num_pedido)) {
				$condicoes['Software.num_pedido LIKE'] = '%'.$num_pedido.'%';
			}
			
			if (!empty($pasta)) {
				$condicoes['Software.pasta LIKE'] = '%'.$pasta.'%';
			}

			if (!empty($num_processo_sei)) {
				$condicoes['Software.num_processo_sei LIKE'] = '%'.$num_processo_sei.'%';
			}

			if (!empty($pasta_juridico)) {
				$condicoes['Software.pasta_juridico LIKE'] = '%'.$pasta_juridico.'%';
			}

			if (!empty($unidade_id)) {
			
				$options['joins'] = array(
					array('table' => 'departamentos_softwares',
						'alias' => 'DepartamentosSoftware',
						'type' => 'inner',
						'conditions' => array(
							'Software.id = DepartamentosSoftware.software_id'
						)
					),
					array('table' => 'unidades',
						'alias' => 'Unidade',
						'type' => 'inner',
						'conditions' => array(
							'DepartamentosSoftware.unidade_id = Unidade.id'
						)
					)
				);
			
				$condicoes['Unidade.id'] = $unidade_id;

			}

			if (!empty($status_id)) {
				$condicoes['Software.status_id'] = $status_id;
			}

			if (!empty($anoDe) && !empty($anoAte)) {
				$condicoes['YEAR(Software.data) >='] = $anoDe;
				$condicoes['YEAR(Software.data) <='] = $anoAte;
			} 
			elseif (!empty($anoDe) && empty($anoAte)) {
				$condicoes['YEAR(Software.data) >='] = $anoDe;
			}	
			elseif (empty($anoDe) && !empty($anoAte)) {
					$condicoes['YEAR(Software.data) <='] = $anoAte;
			}

			if (!empty($inventor_id)) {
		
				$options['joins'] = array(
					array('table' => 'inventores_softwares',
						'alias' => 'InventoresSoftware',
						'type' => 'inner',
						'conditions' => array(
							'Software.id = InventoresSoftware.software_id'
						)
					),
					array('table' => 'inventores',
						'alias' => 'Inventor',
						'type' => 'inner',
						'conditions' => array(
							'InventoresSoftware.inventor_id = Inventor.id'
						)
					)
				);
			
				$condicoes['Inventor.id'] = $inventor_id;
			}

			$options['order'] = array(
				'Software.data' => 'desc'
			);

			$options['group'] = array('Software.id');
	
			//A busca é realizada
			$options['conditions'] = $condicoes;
			$softwares = $this->Software->find('all', $options );
			$this->set('softwares',$softwares);
		}

			// Buscar inventores já associados a algum software
			$params['joins'] = array(
				array('table' => 'inventores_softwares',
					'alias' => 'InventoresSoftware',
					'type' => 'inner',
					'conditions' => array(
						'Inventor.id = InventoresSoftware.inventor_id'
					)
				)
			);

			$params['order'] = array('Inventor.nome ASC');
		
			// group removido pois o list já faz um group
			// $params['group'] = array('Inventor.id');		
			$inventores = $this->Software->Inventor->find('list',$params);		
			// debug($inventores);
		
			$status = $this->Software->Status->find('list');

			$param['order'] = array('Unidade.nome ASC');
			$unidades = $this->Software->Unidade->find('list',$param);

			// ANOS //
			$params = array(
				'fields'=>array('DISTINCT(YEAR(Software.data)) as ano'),
				'order' => array('Software.data ASC'),
				'recursive' => 0
			);
		
			$anosTmp = $this->Software->find('all', $params);
			$anos = array();
		
			for ($i=0; $i < count($anosTmp); $i++) {
				$anos[$anosTmp[$i][0]['ano']] = $anosTmp[$i][0]['ano'];
			}
			$desdes = $ates = $anos;
			$this->set(compact('unidades', 'status', 'inventores', 'desdes', 'ates'));
	}

	function desassociarInventor($idTec = null, $idInventor = null) {
		if (!$idTec || !$idInventor) {
			$this->Session->setFlash(__('Invalid software', true));
			$this->redirect(array('action' => 'index'));
		}
		
		$query = sprintf("DELETE FROM inventores_softwares WHERE inventor_id = %d AND software_id = %d LIMIT 1", $idInventor, $idTec);
		$resultado = $this->Software->query($query);
				
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
		
		$inventores = $this->Software->Inventor->find('list', $params);
		$this->layout = '';
		$this->set('inventores', $inventores);		
	}//ajaxListarInventores

	function ajaxAssociarInventor() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$inventor_id = $_GET['id'];
		$software_id = $_GET['tec_id'];
		
		// checa para ver se este autor já não está associado a este software antes
		$query = sprintf("
		SELECT * FROM inventores_softwares 
		WHERE inventor_id=%d AND software_id=%d
		LIMIT 1", 
		$inventor_id, $software_id );
		$resultado = $this->Software->query($query);
		
		if ( count($resultado) ) {
			// houve resultado na busca, indicando que tentou-se repetir uma associação
			// retorna um JSON com o erro
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Este inventor já está associado com este software.", true) );
			exit;
	}
		
		$query = sprintf("
		INSERT INTO inventores_softwares (
			inventor_id,
			software_id
		) VALUES (%d, %d)", 
		$inventor_id, $software_id );
		$resultado = $this->Software->query($query);
		
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
		$software_id = $_GET['tec_id'];
		
		$query = sprintf("DELETE FROM inventores_softwares WHERE inventor_id = %d AND software_id = %d LIMIT 1", $inventor_id, $software_id);
		$resultado = $this->Software->query($query);
		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Inventor desassociado com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao desassociar este inventor. Saia do sistema e tente novamente.", true) );
		}
		
	}//ajaxDesassociarInventor

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
		
		$departamentos = $this->Software->Departamento->find('all', $params);
		$this->layout = '';
		$this->set('departamentos', $departamentos);	
	}//ajaxListarDepartamentos

	function ajaxAssociarDepartamento() {
		Configure::write('debug', 0);
		$this->autoRender = false;

		$departamento_id = $_GET['id'];
		$software_id = $_GET['tec_id'];
		$unidade_id = $_GET['uni_id'];
		
		// checa para ver se este autor já não está associado a este software antes
		$query = sprintf("
		SELECT * FROM departamentos_softwares 
		WHERE departamento_id=%d AND software_id=%d
		LIMIT 1", 
		$departamento_id, $software_id );
		$resultado = $this->Software->query($query);

		if ( count($resultado) ) {
			// houve resultado na busca, indicando que tentou-se repetir uma associação
			// retorna um JSON com o erro
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Esta origem já está associada a este software.", true) );
			exit;
		}
		
		$query = sprintf("
		INSERT INTO departamentos_softwares (
			software_id,
			departamento_id,
			unidade_id
		) VALUES (%d, %d, %d)", 
		$software_id, $departamento_id, $unidade_id);
		$resultado = $this->Software->query($query);

		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Origem associada com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __($query, true) );
		}
	}//ajaxAssociarDepartamento

	function ajaxDesassociarDepartamento() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$departamento_id = $_GET['id'];
		$software_id = $_GET['tec_id'];
		
		$query = sprintf("DELETE FROM departamentos_softwares WHERE departamento_id = %d AND software_id = %d LIMIT 1", $departamento_id, $software_id);
		$resultado = $this->Software->query($query);
		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Departamento desassociado com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao desassociar este departamento. Saia do sistema e tente novamente.", true) );
		}
		
	}//ajaxDesassociarDepartamento

	function ajaxListarTitulares() {
		Configure::write('debug', 0);
				
		$nome = $_GET['term'];
				
		$params = array(
			'fields'=>array('id','nome'),
			'order' => array('Titular.nome ASC'),
			'conditions' => array('Titular.nome LIKE' => $nome.'%'),
			'recursive' => 0
		);
		
		$titulares = $this->Software->Titular->find('list', $params);
		$this->layout = '';
		$this->set('titulares', $titulares);		
	}//ajaxListarTitulares

	function ajaxAssociarTitular() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$titular_id = $_GET['id'];
		$software_id = $_GET['tec_id'];
		
		// checa para ver se este autor já não está associado a este software antes
		$query = sprintf("
		SELECT * FROM softwares_titulares 
		WHERE software_id=%d AND titular_id=%d
		LIMIT 1", 
		$software_id, $titular_id );
		$resultado = $this->Software->query($query);

		if ( count($resultado) ) {
			// houve resultado na busca, indicando que tentou-se repetir uma associação
			// retorna um JSON com o erro
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Este titular já está associada a este software.", true) );
			exit;
		}
		
		$query = sprintf("
		INSERT INTO softwares_titulares (
			software_id,
			titular_id
		) VALUES (%d, %d)", 
		$software_id, $titular_id );
		$resultado = $this->Software->query($query);

		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Titular associado com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao desassociar este titular. Saia do sistema e tente novamente.", true) );
		}
		
	}//ajaxAssociarTitular

	function ajaxDesassociarTitular() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$titular_id = $_GET['id'];
		$software_id = $_GET['tec_id'];
		
		$query = sprintf("DELETE FROM softwares_titulares WHERE software_id = %d AND titular_id = %d LIMIT 1", $software_id, $titular_id);
		$resultado = $this->Software->query($query);
		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Titular desassociado com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao desassociar este titular. Saia do sistema e tente novamente.", true) );
		}
		
	}//ajaxDesassociarTitular

	function ajaxAdicionarArquivos($id = null) {
		// Reference general return: printf(json_encode(var_export($this->data, true)));exit;
		Configure::write('debug', 0);
		$this->autoRender = false;

		if ( empty($this->data) /*|| empty($this->data['Tecnologia']['arquivo']['tmp_name'])*/ ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, 'Favor enviar um arquivo.');exit;
		}

		// initialize the upload object
		$this->Upload->upload($this->data['Software']['arquivo'] );


		$uuid = String::uuid();
		$filename = $uuid;
		
		$nomeOriginal = $this->data['Software']['arquivo']['name'];
		$mimetype     = $this->data['Software']['arquivo']['type'];

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
		$saving['Arquivo']['software_id'] 	= $id;
		$saving['Arquivo']['mimetype']      = $mimetype;
		$this->Software->Arquivo->create();
		$this->Software->Arquivo->save($saving);

		printf('{"sucesso":%d, "nomeOriginal":"%s", "id":"%s"}', 1, $nomeOriginal, $filename);
	}
}
