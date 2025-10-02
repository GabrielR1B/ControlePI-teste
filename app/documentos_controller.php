<?php
class DocumentosController extends AppController {

	var $name = 'Documentos';
	
	function index() {
		$this->Documento->recursive = 0;
		$this->set('documentos', $this->paginate());
	}
	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid document', true));
			$this->redirect(array('action' => 'index'));
		}
		
		$documento = $this->Documento->findById($id);
		$this->set('documento',$documento);
	}

	function add() {
		if (!empty($this->data)) {
			$this->Documento->create();
			if ($this->Documento->save($this->data)) {
				$this->Session->setFlash(__('O tipo de documento foi salvo com sucesso.', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The document could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid document', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Documento->save($this->data)) {
				$this->Session->setFlash(__('O tipo de documento foi salvo com sucesso.', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The document could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Documento->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for document', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Documento->delete($id)) {
			$this->Session->setFlash(__('Documento deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Documento was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>