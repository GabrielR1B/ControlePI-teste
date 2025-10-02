<?php
class EscritoriosController extends AppController {

	var $name = 'Escritorios';

	function index() {
		$this->Escritorio->recursive = 0;
		$this->set('escritorios', $this->paginate());
	}
	
	//function view($id = null) {
	//	if (!$id) {
	//		$this->Session->setFlash(__('Invalid status', true));
	//		$this->redirect(array('action' => 'index'));
	//	}
	//	$this->Escritorio->recursive = 2;
	//	
	//	$options['conditions'] = array(
	//		"Escritorio.id = $id"
	//	);
	//	
	//	$status = $this->Escritorio->find('first', $options );
	//	// debug($status);
	//	$this->set('escritorio',$escritorio);
	//}

	function add() {
		if (!empty($this->data)) {
			$this->Escritorio->create();
			if ($this->Escritorio->save($this->data)) {
				$this->Session->setFlash(__('Escritório incluído com sucesso.', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The escritorio could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Escritório inválido.', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Escritorio->save($this->data)) {
				$this->Session->setFlash(__('Escritório editado com sucesso.', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The escritorio could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Escritorio->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for escritorio', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Escritorio->delete($id)) {
			$this->Session->setFlash(__('Escritorio removido com sucesso.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Não foi possível remover o escritório.', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>