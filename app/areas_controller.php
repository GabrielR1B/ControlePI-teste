<?php
class AreasController extends AppController {

	var $name = 'Areas';
	
	function index() {
		$this->Area->recursive = 0;
		$this->set('areas', $this->paginate());
	}
	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid area', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Area->recursive = 2;
		
		$options['conditions'] = array(
			"Area.id = $id"
		);
		
		$area = $this->Area->find('first', $options );
		// debug($inventor);
		$this->set('area',$area);
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
			if ($this->Area->save($this->data)) {
				$this->Session->setFlash(__('The area has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The area could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Area->read(null, $id);
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
}
?>