<?php
class InventoresTecnologiasController extends AppController {
	var $name = 'InventoresTecnologias';

	public function edit($inventor_id, $tecnologia_id) {
		$this->loadModel('InventorTecnologia');
		if (!$inventor_id && !$tecnologia_id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Inventor', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->InventorTecnologia->save($this->data)) {
				$this->Session->setFlash(__('The inventor has been saved', true));
				$this->redirect(array('controller'=>'tecnologias','action' => 'view',$tecnologia_id));
			} else {
				$this->Session->setFlash(__('The inventor could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->InventorTecnologia->find('all',array('conditions'=>array(
																		'InventorTecnologia.tecnologia_id'=>$tecnologia_id,	
																		'InventorTecnologia.inventor_id'=>$inventor_id
																		)
																)
															);
		}

		$this->loadModel('Categoria');
		$this->loadModel('Titulo');

		$inventor_tecnologia = $this->InventorTecnologia->find('first',array('conditions'=>array(
																		'InventorTecnologia.tecnologia_id'=>$tecnologia_id,	
																		'InventorTecnologia.inventor_id'=>$inventor_id
																		)
																)
															);

		$categorias = $this->Categoria->find('list');
		$titulos = $this->Titulo->find('list');
		$this->set(compact('inventor_tecnologia','titulos','categorias'));
		
	}
}