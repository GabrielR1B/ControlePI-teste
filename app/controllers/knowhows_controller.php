<?php
class KnowhowsController extends AppController {

	var $name = 'Knowhows';
	var $components = array('Upload');

	function index() {
		$this->Knowhow->recursive = 0;
		$this->set('knowhows', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid knowhow', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('knowhow', $this->Knowhow->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Knowhow->create();
			if ($this->Knowhow->save($this->data)) {
				$this->Session->setFlash(__('The knowhow has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The knowhow could not be saved. Please, try again.', true));
			}
		}
		$departamentos = $this->Knowhow->Departamento->find('list');
		$titulares = $this->Knowhow->Titular->find('list');
		$inventores = $this->Knowhow->Inventor->find('list');
		$areas = $this->Knowhow->Area->find('list');
		$status = $this->Knowhow->Status->find('list');
		$this->set(compact('departamentos', 'inventores','titulares','areas','status'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid knowhow', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Knowhow->save($this->data)) {
				$this->Session->setFlash(__('The knowhow has been saved', true));
				$this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(__('The knowhow could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Knowhow->read(null, $id);
			$arquivos = $this->data['Arquivo'];
		}

		$knowhow = $this->Knowhow->read(null, $id);
		$departamentos = $knowhow['Departamento'];
		$inventores = $knowhow['Inventor'];
		$unidades = $this->Knowhow->Unidade->find('list');
		$titulares = $this->Knowhow->Titular->find('list');
		$areas = $this->Knowhow->Area->find('list');
		$empresas = $knowhow['Empresa'];
		$status = $this->Knowhow->Status->find('list');

		$knowhow_id = $id;
		$this->set(compact('departamentos', 'inventores', 'empresas','titulares','knowhow_id','unidades','areas','status','arquivos'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for knowhow', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Knowhow->delete($id)) {
			$this->Session->setFlash(__('Knowhow deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Knowhow was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

	function search(){

		if (!empty($this->data)) {
			$condicoes = array(); // armazena as condicoes da busca
			$options   = array(); // será passada para a funcao 

			$titulo      = $this->data['Knowhow']['titulo'];
			$pasta       = $this->data['Knowhow']['pasta'];
			$pasta_juridico = $this->data['Knowhow']['pasta_juridico'];
			$num_processo_sei = $this->data['Knowhow']['num_processo_sei'];
			$unidade_id  = $this->data['Knowhow']['unidade_id'];
			$inventor_id = $this->data['Inventor']['Inventor'];
			$anoDe       = $this->data['Knowhow']['desde'];
			$anoAte      = $this->data['Knowhow']['ate'];

			if (!empty($titulo)) {
				$condicoes['Knowhow.titulo LIKE'] = '%'.$titulo.'%';
			}

			if (!empty($pasta)) {
				$condicoes['Knowhow.pasta LIKE'] = '%'.$pasta.'%';
			}

			if (!empty($pasta_juridico)) {
				$condicoes['Knowhow.pasta_juridico LIKE'] = '%'.$pasta_juridico.'%';
			}

			if (!empty($num_processo_sei)) {
				$condicoes['Knowhow.num_processo_sei LIKE'] = '%'.$num_processo_sei.'%';
			}

			if (!empty($unidade_id)) {
			
				$options['joins'] = array(
					array('table' => 'departamentos_knowhows',
						'alias' => 'DepartamentosKnowhow',
						'type' => 'inner',
						'conditions' => array(
							'Knowhow.id = DepartamentosKnowhow.knowhow_id'
						)
					),
					array('table' => 'unidades',
						'alias' => 'Unidade',
						'type' => 'inner',
						'conditions' => array(
							'DepartamentosKnowhow.unidade_id = Unidade.id'
						)
					)
				);
			
				$condicoes['Unidade.id'] = $unidade_id;

			}

			if (!empty($anoDe) && !empty($anoAte)) {
				$condicoes['YEAR(Knowhow.data) >='] = $anoDe;
				$condicoes['YEAR(Knowhow.data) <='] = $anoAte;
			} 
			elseif (!empty($anoDe) && empty($anoAte)) {
				$condicoes['YEAR(Knowhow.data) >='] = $anoDe;
			}	
			elseif (empty($anoDe) && !empty($anoAte)) {
					$condicoes['YEAR(Knowhow.data) <='] = $anoAte;
			}

			if (!empty($inventor_id)) {
		
				$options['joins'] = array(
					array('table' => 'inventores_knowhows',
						'alias' => 'InventoresKnowhow',
						'type' => 'inner',
						'conditions' => array(
							'Knowhow.id = InventoresKnowhow.knowhow_id'
						)
					),
					array('table' => 'inventores',
						'alias' => 'Inventor',
						'type' => 'inner',
						'conditions' => array(
							'InventoresKnowhow.inventor_id = Inventor.id'
						)
					)
				);
			
				$condicoes['Inventor.id'] = $inventor_id;
			}

			$options['group'] = array('Knowhow.id');
	
			//A busca é realizada
			$options['order'] = array(
				'Knowhow.data' => 'desc'
			);
	
			$options['conditions'] = $condicoes;

			$knowhows = $this->Knowhow->find('all', $options );
			$this->set('knowhows',$knowhows);
		}

		// Buscar inventores já associados a algum knowhow
		$params['joins'] = array(
			array('table' => 'inventores_knowhows',
				'alias' => 'InventoresKnowhow',
				'type' => 'inner',
				'conditions' => array(
					'Inventor.id = InventoresKnowhow.inventor_id'
				)
			)
		);

		$params['order'] = array('Inventor.nome ASC');
		$inventores = $this->Knowhow->Inventor->find('list',$params);

		$param['order'] = array('Unidade.nome ASC');
		$unidades = $this->Knowhow->Unidade->find('list',$param);

		// ANOS //
		$params = array(
			'fields'=>array('DISTINCT(YEAR(Knowhow.data)) as ano'),
			'order' => array('Knowhow.data ASC'),
			'recursive' => 0
		);
		
		$anosTmp = $this->Knowhow->find('all', $params);
		$anos = array();
		
		for ($i=0; $i < count($anosTmp); $i++) {
			$anos[$anosTmp[$i][0]['ano']] = $anosTmp[$i][0]['ano'];
		}
		$desdes = $ates = $anos;
		$this->set(compact('unidades', 'inventores', 'desdes', 'ates'));
	}

	function desassociarInventor($idTec = null, $idInventor = null) {
		if (!$idTec || !$idInventor) {
			$this->Session->setFlash(__('Invalid tecnologia', true));
			$this->redirect(array('action' => 'index'));
		}
		
		$query = sprintf("DELETE FROM inventores_knowhows WHERE knowhow_id = %d AND inventor_id = %d LIMIT 1", $idTec, $idInventor);
		$resultado = $this->Knowhow->query($query);
				
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
		
		$inventores = $this->Knowhow->Inventor->find('list', $params);
		$this->layout = '';
		$this->set('inventores', $inventores);		
	}//ajaxListarInventores

	function ajaxDesassociarInventor() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$inventor_id = $_GET['id'];
		$knowhow_id = $_GET['tec_id'];
		
		$query = sprintf("DELETE FROM inventores_knowhows WHERE inventor_id = %d AND knowhow_id = %d LIMIT 1", $inventor_id, $knowhow_id);
		$resultado = $this->Knowhow->query($query);
		
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
		
		$departamentos = $this->Knowhow->Departamento->find('all', $params);
		$this->layout = '';
		$this->set('departamentos', $departamentos);	
	}//ajaxListarDepartamentos


	function ajaxAssociarDepartamento() {
		Configure::write('debug', 0);
		$this->autoRender = false;

		$departamento_id = $_GET['id'];
		$knowhow_id = $_GET['tec_id'];
		$unidade_id = $_GET['uni_id'];
		
		// checa para ver se este autor já não está associado a esta tecnologia antes
		$query = sprintf("
		SELECT * FROM departamentos_knowhows 
		WHERE departamento_id=%d AND knowhow_id=%d
		LIMIT 1", 
		$departamento_id, $knowhow_id );
		$resultado = $this->Knowhow->query($query);

		if ( count($resultado) ) {
			// houve resultado na busca, indicando que tentou-se repetir uma associação
			// retorna um JSON com o erro
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Esta origem já está associada a este knowhow.", true) );
			exit;
		}
		
		$query = sprintf("
		INSERT INTO departamentos_knowhows (
			knowhow_id,
			departamento_id,
			unidade_id
		) VALUES (%d, %d, %d)", 
		$knowhow_id, $departamento_id, $unidade_id);
		$resultado = $this->Knowhow->query($query);

		
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
		$knowhow_id = $_GET['tec_id'];
		
		$query = sprintf("DELETE FROM departamentos_knowhows WHERE departamento_id = %d AND knowhow_id = %d LIMIT 1", $departamento_id, $knowhow_id);
		$resultado = $this->Knowhow->query($query);
		
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
		$knowhow_id = $_GET['tec_id'];
		
		// checa para ver se este autor já não está associado a esta tecnologia antes
		$query = sprintf("
		SELECT * FROM inventores_knowhows 
		WHERE inventor_id=%d AND knowhow_id=%d
		LIMIT 1", 
		$inventor_id, $knowhow_id );
		$resultado = $this->Knowhow->query($query);
		
		if ( count($resultado) ) {
			// houve resultado na busca, indicando que tentou-se repetir uma associação
			// retorna um JSON com o erro
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Este inventor já está associado com esta tecnologia.", true) );
			exit;
	}
		
		$query = sprintf("
		INSERT INTO inventores_knowhows (
			inventor_id,
			knowhow_id
		) VALUES (%d, %d)", 
		$inventor_id, $knowhow_id );
		$resultado = $this->Knowhow->query($query);
		
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
		$this->Upload->upload($this->data['Knowhow']['arquivo'] );


		$uuid = String::uuid();
		$filename = $uuid;
		
		$nomeOriginal = $this->data['Knowhow']['arquivo']['name'];
		$mimetype     = $this->data['Knowhow']['arquivo']['type'];

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
		$saving['Arquivo']['knowhow_id'] 	= $id;
		$saving['Arquivo']['mimetype']      = $mimetype;
		$this->Knowhow->Arquivo->create();
		$this->Knowhow->Arquivo->save($saving);

		printf('{"sucesso":%d, "nomeOriginal":"%s", "id":"%s"}', 1, $nomeOriginal, $filename);
	}
}
