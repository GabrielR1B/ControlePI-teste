<?php
class EmpresasController extends AppController {

	var $name = 'Empresas';
	
	function index() {
		$this->Empresa->recursive = 0;
		$this->set('empresas', $this->paginate());
	}

	function add() {
		if (!empty($this->data)) {
			
			$nome = $this->data['Empresa']['nome'];
			$existe = $this->Empresa->findByNome($nome);
			
			if ($existe) {
				$this->Session->setFlash('Já existe no sistema uma empresa com este nome');	
				$this->redirect(array('action' => 'add'));exit;
			}
			$this->Empresa->create();
			if ($this->Empresa->save($this->data)) {
				$this->Session->setFlash(__('A empresa foi criada com sucesso.', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('A empresa não pôde ser criada.Tente novamente mais tarde.', true));
			}
		}
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Empresa inexistente.', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Empresa->recursive = 1;
		$empresa = $this->Empresa->findById($id);

		$pis = array();
		foreach ($empresa['Tecnologia'] as $tecnologia) {
			array_push($pis, array('empresa_tecnologia_id'=>$tecnologia['EmpresasTecnologia']['id'], 'pi_id'=>$tecnologia['id'], 'natureza'=>'Patente Nacional', 'num_pedido'=>$tecnologia['num_pedido'], 'pasta'=>$tecnologia['pasta'], 'titulo'=>$tecnologia['titulo'], 'tipo_relacao_id'=>$tecnologia['EmpresasTecnologia']['tipo_relacao_id'], 'controller'=>'tecnologias' ));
		}
		foreach ($empresa['PatenteInternacional'] as $tecnologia) {
			array_push($pis, array('empresa_tecnologia_id'=>$tecnologia['EmpresasTecnologia']['id'], 'pi_id'=>$tecnologia['id'], 'natureza'=>'Patente Internacional', 'num_pedido'=>$tecnologia['num_pedido'], 'pasta'=>$tecnologia['pasta'], 'titulo'=>$tecnologia['titulo'], 'tipo_relacao_id'=>$tecnologia['EmpresasTecnologia']['tipo_relacao_id'], 'controller'=>'patentes_internacionais'  ));
		}
		foreach ($empresa['Desenho'] as $tecnologia) {
			array_push($pis, array('empresa_tecnologia_id'=>$tecnologia['EmpresasTecnologia']['id'], 'pi_id'=>$tecnologia['id'], 'natureza'=>'Desenho Industrial', 'num_pedido'=>$tecnologia['num_pedido'], 'pasta'=>$tecnologia['pasta'], 'titulo'=>$tecnologia['titulo'], 'tipo_relacao_id'=>$tecnologia['EmpresasTecnologia']['tipo_relacao_id'], 'controller'=>'desenhos'  ));
		}
		foreach ($empresa['Marca'] as $tecnologia) {
			array_push($pis, array('empresa_tecnologia_id'=>$tecnologia['EmpresasTecnologia']['id'], 'pi_id'=>$tecnologia['id'], 'natureza'=>'Marca', 'num_pedido'=>$tecnologia['processo'], 'pasta'=>$tecnologia['pasta'], 'titulo'=>$tecnologia['nome'], 'tipo_relacao_id'=>$tecnologia['EmpresasTecnologia']['tipo_relacao_id'], 'controller'=>'marcas'  ));
		}
		foreach ($empresa['Software'] as $tecnologia) {
			array_push($pis, array('empresa_tecnologia_id'=>$tecnologia['EmpresasTecnologia']['id'], 'pi_id'=>$tecnologia['id'], 'natureza'=>'Software', 'num_pedido'=>$tecnologia['num_pedido'], 'pasta'=>$tecnologia['pasta'], 'titulo'=>$tecnologia['titulo'], 'tipo_relacao_id'=>$tecnologia['EmpresasTecnologia']['tipo_relacao_id'], 'controller'=>'softwares'  ));
		}
		foreach ($empresa['Knowhow'] as $tecnologia) {
			array_push($pis, array('empresa_tecnologia_id'=>$tecnologia['EmpresasTecnologia']['id'], 'pi_id'=>$tecnologia['id'], 'natureza'=>'Knowhow', 'num_pedido'=>'', 'pasta'=>$tecnologia['pasta'], 'titulo'=>$tecnologia['titulo'], 'tipo_relacao_id'=>$tecnologia['EmpresasTecnologia']['tipo_relacao_id'], 'controller'=>'knowhows'  ));
		}

		$this->set(compact('empresa','pis'));
	}

	function edit($id=null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Empresa Inválida', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Empresa->save($this->data)) {
				$this->Session->setFlash(__('Alteração efetuada com sucesso!', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('A alteração não pôde ser salva. Por favor, tente novamente.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Empresa->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Id inválido para empresas', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Empresa->delete($id)) {
			$this->Session->setFlash(__('Empresa removida com sucesso.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Ocorreu um erro ao remover a empresa.', true));
		$this->redirect(array('action' => 'index'));
	}

	function ajaxListarEmpresas(){
		Configure::write('debug', 0);
		$this->autoRender = false;
				
		$nome = $_GET['term'];
				
		$params = array(
			'fields'=>array('id','nome'),
			'order' => array('Empresa.nome ASC'),
			'conditions' => array('Empresa.nome LIKE' => '%'.$nome.'%'),
			'recursive' => 0
		);
		
		$empresas = $this->Empresa->find('all', $params);

		$itens = array();
		foreach ($empresas as $empresa) {
			$item = sprintf('{"id":"%d", "value":"%s - Ofertada", "tipo_vinculo":"%s"}', $empresa['Empresa']['id'], $empresa['Empresa']['nome'], '1');
			array_push($itens, $item);
			$item = sprintf('{"id":"%d", "value":"%s - Autorização de Teste", "tipo_vinculo":"%s"}', $empresa['Empresa']['id'], $empresa['Empresa']['nome'], '3');
			array_push($itens, $item);
			$item = sprintf('{"id":"%d", "value":"%s - Licenciada", "tipo_vinculo":"%s"}', $empresa['Empresa']['id'], $empresa['Empresa']['nome'], '2');
			array_push($itens, $item);
		}

		echo '[' . implode(",", $itens) . ']';
	}

	function ajaxAssociarEmpresa(){
		$this->autoRender = false;
		$empresa_id = $_GET['empresa_id'];
		$natureza_id = $_GET['natureza_id'];
		$pi_id = $_GET['pi_id'];
		$tipo_relacao_id = $_GET['tipo_relacao_id'];

		// checa para ver se este autor já não está associado a esta tecnologia antes
		$query = sprintf("SELECT * FROM empresas_tecnologias WHERE empresa_id=%d AND natureza_pi_id=%d AND pi_id=%d AND tipo_relacao_id=%d LIMIT 1", $empresa_id, $natureza_id, $pi_id, $tipo_relacao_id);
		$resultado = $this->Empresa->query($query);
		
		if (count($resultado)) {
			// houve resultado na busca, indicando que tentou-se repetir uma associação
			// retorna um JSON com o erro
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Esta empresa já está associada com esta tecnologia.", true) );
			exit;
		}

		//$query = sprintf("INSERT INTO empresas_tecnologias (empresa_id,natureza_pi_id,pi_id,tipo_relacao_id) VALUES (%d, %d, %d, %d)", $empresa_id, $natureza_id, $pi_id, $tipo_relacao_id);
		$empresa = array('empresa_id'=>$empresa_id, 'natureza_pi_id'=>$natureza_id, 'pi_id'=>$pi_id, 'tipo_relacao_id'=>$tipo_relacao_id);
		$this->Empresa->EmpresasTecnologia->save($empresa);
		//$resultado = $this->Empresa->query($query);
		$id = $this->Empresa->EmpresasTecnologia->getLastInsertId();
		
		if ($id) {
			printf('{"sucesso":%d, "id":%d, "retorno":"%s"}', 1, $id, __("Empresa associada com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao associar esta empresa. Saia do sistema e tente novamente.", true) );
		}
	}

	function ajaxDesassociarEmpresa() {
		$this->autoRender = false;
		$empresa_tecnologia_id = $_GET['empresa_tecnologia_id'];
		if (!$empresa_tecnologia_id) {
			$this->Session->setFlash(__('Empresa inválida', true));
			$this->redirect(array('action' => 'index'));
		}
		
		$query = sprintf("DELETE FROM empresas_tecnologias WHERE id = %d LIMIT 1", $empresa_tecnologia_id);
		$resultado = $this->Empresa->EmpresasTecnologia->query($query);
		
		if($resultado){
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Empresa desassociada com sucesso.", true) );
		}else{
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao desassociar esta empresa. Saia do sistema e tente novamente.", true) );
		}
	}
}
?>