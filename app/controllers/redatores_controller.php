<?php
class RedatoresController extends AppController {

	var $name = 'Redatores';
	
	var $paginate = array(
		'limit' => 50
	);

	function index() {
		$this->Redator->recursive = 0;
		$this->set('redatores', $this->paginate());
	}
	
	function view($id = null) {
		$this->Redator->recursive = 1;

		$tecnologias = $this->paginate('Tecnologia', array("Tecnologia.redator_id LIKE $id"));
		$redator = $this->Redator->findById("$id");
				
		$this->set(compact('patentes', 'redator'));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Redator->create();
			if ($this->Redator->save($this->data)) {
				$this->Session->setFlash(__('Redator incluído com sucesso.', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The redator could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid redator', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Redator->save($this->data)) {
				$this->Session->setFlash(__('The redator has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The redator could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Redator->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for redator', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Redator->delete($id)) {
			$this->Session->setFlash(__('Redator deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Redator was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>