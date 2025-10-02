<?php
class AndamentosController extends AppController {

	var $name = 'Andamentos';

	var $paginate = array(
		'limit' => 50,
		'order' => array(
			'Tecnologia.data' => 'desc'
		)
	);

	function index() {
		$this->Andamento->recursive = 0;
		$this->set('andamentos', $this->Andamento->find('all'));
	}
	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Andamento', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Andamento->recursive = 0;
		$this->Andamento->Tecnologia->recursive = 0;
		
		$options['conditions'] = array(
			"Andamento.id = $id"
		);
		
		$andamento = $this->Andamento->find('first', $options );

		$id = $andamento['Andamento']['id'];
		$tecnologias = $this->paginate('Tecnologia', array("Tecnologia.andamento_id LIKE $id"));

				
		$this->set(compact('tecnologias','andamento'));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Andamento->create();
			if ($this->Andamento->save($this->data)) {
				$this->Session->setFlash(__('The Andamento has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Andamento could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Andamento', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Andamento->save($this->data)) {
				$this->Session->setFlash(__('The Andamento has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The Andamento could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Andamento->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Andamento', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Andamento->delete($id)) {
			$this->Session->setFlash(__('Andamento deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Andamento was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>