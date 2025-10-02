<?php
class DesenhosInventoresController extends AppController {
	var $name = 'DesenhosInventores';

	public function edit($inventor_id, $desenho_id) {
		$this->loadModel('DesenhoInventor');
		if (!$inventor_id && !$desenho_id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Inventor', true));
			$this->redirect(array('controller' => 'desenhos', 'action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->DesenhoInventor->save($this->data)) {
				$this->Session->setFlash(__('The inventor has been saved', true));
				$this->redirect(array('controller'=>'desenhos','action' => 'view',$desenho_id));
			} else {
				$this->Session->setFlash(__('The inventor could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->DesenhoInventor->find('all',array('conditions'=>array(
																		'DesenhoInventor.desenho_id'=>$desenho_id,	
																		'DesenhoInventor.inventor_id'=>$inventor_id
																		)
																)
															);
		}

		$this->loadModel('Categoria');
		$this->loadModel('Titulo');

		$desenho_inventor = $this->DesenhoInventor->find('first',array('conditions'=>array(
																		'DesenhoInventor.desenho_id'=>$desenho_id,	
																		'DesenhoInventor.inventor_id'=>$inventor_id
																		)
																)
															);

		$categorias = $this->Categoria->find('list');
		$titulos = $this->Titulo->find('list');
		$this->set(compact('desenho_inventor','titulos','categorias'));
		
	}
}