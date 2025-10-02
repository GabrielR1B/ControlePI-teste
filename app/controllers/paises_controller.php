<?php
class PaisesController extends AppController {

	var $name = 'Paises';
	
	var $paginate = array(
		'limit' => 50
	);

	function index() {
		$this->Pais->recursive = 0;
		$this->set('paises', $this->paginate());
	}
	
	function view($id = null) {
		$this->Pais->recursive = 1;

		$patentes = $this->paginate('PatenteInternacional', array("PatenteInternacional.pais_id LIKE $id"));
		$pais = $this->Pais->findById("$id");

				
		$this->set(compact('patentes', 'pais'));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Pais->create();
			if ($this->Pais->save($this->data)) {
				$this->Session->setFlash(__('The pais has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The pais could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid pais', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Pais->save($this->data)) {
				$this->Session->setFlash(__('The pais has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The pais could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Pais->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for pais', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Pais->delete($id)) {
			$this->Session->setFlash(__('Pais deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Pais was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

	function ajaxPaises(){
		$this->autoRender = false;
		$this->Pais->Tecnologia->recursive = -1;

		$query = $_GET['q'];
		
		$paises = $this->Pais->find('all',array('conditions' => array('Pais.nome LIKE' => '%'.$query.'%'),
														'fields' => array('Pais.id', 'Pais.nome'),
														'limit'=>10
														)
										);
		
		$resultado = array();

		foreach ($paises as $pais) {
			array_push($resultado, $pais['Pais']);
		}

		return json_encode($resultado);
	}
}
?>