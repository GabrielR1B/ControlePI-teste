<?php
class ContatosController extends AppController {

	var $name = 'Contatos';

	function index() {
		$this->Contato->recursive = 0;
		$this->set('contatos', $this->paginate());
	}
	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid area', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('contato',$this->Contato->find('first', array('conditions'=>array('Contato.id'=>$id))));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Contato->create();
			if ($this->Contato->save($this->data)) {
				$this->Session->setFlash(__('The area has been saved', true));
				$this->redirect(array('action' => 'view',$this->Contato->id));
			} else {
				$this->Session->setFlash(__('The area could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid contato', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Contato->save($this->data)) {
				$this->Session->setFlash(__('The contato has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contato could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Contato->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for contato', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Contato->delete($id)) {
			$this->Session->setFlash(__('Contato deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Contato was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

	function search() {
		$this->autoRender = '';
		$this->layout = '';


		$resultado = array();
		$sEcho = intval($_GET['sEcho']);
		
		$resultado['aaData'] = array();
		$resultado['iTotalRecords'] = $this->Contato->find('count');

		$limit = 150;

		$query = $_GET['sSearch'];
		if ( isset($query) && $query != "" ){
			$contatos =  $this->Contato->find('all',array('conditions'=>array(
																			'OR'=>array(
																					'Contato.nome LIKE'=>'%'.$query.'%',
																					'Contato.departamento LIKE'=>'%'.$query.'%',
																					'Contato.unidade LIKE'=>'%'.$query.'%',
																					'Contato.telefones LIKE'=>'%'.$query.'%',
																					'Contato.email LIKE'=>'%'.$query.'%'
																				)
																			)
														)
											);
		
			foreach ($contatos as $contato) {
				array_push($resultado['aaData'], array(
													"<a href='./contatos/view/".$contato['Contato']['id']."'>".$contato['Contato']['nome']."</a>",
													$contato['Contato']['unidade'],
													$contato['Contato']['departamento'],
													$contato['Contato']['telefones'],
													$contato['Contato']['email'],
													$contato['Contato']['endereco'],
												)
					);
			}
			$resultado['iTotalDisplayRecords'] = sizeof($contatos);
		}else{
			$contatos =  $this->Contato->find('all',array('limit'=>$limit,
														  'conditions'=>array('Contato.id >'=>($sEcho-1)*$limit),
														  )
											);

			foreach ($contatos as $contato) {
				array_push($resultado['aaData'], array(
													"<a href='./contatos/view/".$contato['Contato']['id']."'>".$contato['Contato']['nome']."</a>",
													$contato['Contato']['unidade'],
													$contato['Contato']['departamento'],
													$contato['Contato']['telefones'],
													$contato['Contato']['email'],
													$contato['Contato']['endereco'],
												)
					);

			}
			$resultado['iTotalDisplayRecords'] = $this->Contato->find('count');
		}
		echo json_encode($resultado);
	}
}
?>