<?php
class TitularesController extends AppController {

    var $name = 'Titulares';   
    
    var $paginate = array('limit' => 50,
    					  'order' => array(
    					  				'Titular.nome' => 'asc'
    					  				) 
    				);

	function index() {
		$this->Titular->recursive = 0;
		$this->set('titulares', $this->paginate());
	}

	function add() {
		if (!empty($this->data)) {
			//print_r($this->data);
			//exit();

			$nome = $this->data['Titular']['nome'];

			$this->data['Titular']['cnpj'] = preg_replace('/[^0-9]+/', '', $this->data['Titular']['cnpj']);
			$cnpj = $this->data['Titular']['cnpj'];

			$existeNome = $this->Titular->findByNome($nome);
			$existeCnpj = $this->Titular->findByCnpj($cnpj);

			if (strlen($cnpj) != 14) {
				$this->Session->setFlash('CNPJ inválido.');	
				$this->redirect(array('action' => 'add'));
			}
			
			if ($existeNome || $existeCnpj) {
				$this->Session->setFlash('Já há no sistema um titular com este nome ou CNPJ');	
				$this->redirect(array('action' => 'add'));
			}

			$this->Titular->create();
			if ($this->Titular->save($this->data)) {
				$this->Session->setFlash('Titular adicionado com sucesso!');
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash('Please correct the errors');
			}
		}
	}

	function edit($id=null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Titular Inválido', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->data['Titular']['cnpj'] = preg_replace('/[^0-9]+/', '', $this->data['Titular']['cnpj']);
			$cnpj = $this->data['Titular']['cnpj'];

			if ($this->Titular->save($this->data)) {
				$this->Session->setFlash(__('Alteração efetuada com sucesso!', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('A alteração não pôde ser salva. Por favor, tente novamente.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Titular->read(null, $id);
		}
	}

	function delete() {
		$this->Titular->delete();
		$this->Session->setFlash('Titular deleted');
		$this->redirect(array('action' => 'index'));
	}

	function listar($excel='') {			
		$this->Titular->recursive = -1;
		
		$query = "SELECT i.id AS id, i.nome AS nome, count(it.titular_id) AS total
		FROM titulares i LEFT JOIN patentes_titulares it
		ON i.id = it.titular_id GROUP BY i.id
		ORDER BY total DESC, nome ASC";
		
		$titulares = $this->Titular->query($query);
		// print_r($inventores);exit;		
		
		if ($excel) {
			$saida = '';
			foreach ($titulares as $titular) {
				$saida .= sprintf("%s,%d\n", $titular['i']['nome'], $titular[0]['total']);
			}
			echo $saida;
			exit;			
		}		
		
		$this->set('titulares', $titulares);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid inventor', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Titular->recursive = 2;
		
		$options['conditions'] = array(
			"Titular.id = $id"
		);
		
		$titular = $this->Titular->find('first', $options );
		$this->set('titular',$titular);
	}

	function search() {
		$this->autoRender = '';
		$this->layout = '';

		$resultado = array();
		$sEcho = intval($_GET['sEcho']);
		
		$resultado['aaData'] = array();
		$resultado['iTotalRecords'] = $this->Titular->find('count');

		$limit = 50;

		$query = $_GET['sSearch'];
		$cnpj = $_GET['sSearch'];
		if ( (isset($query) || isset($cnpj)) && ($query != "" || $cnpj != "") ){
			$titulares =  $this->Titular->find('all',array('conditions'=>array(
																			'OR'=>array(
																					'Titular.nome LIKE'=>'%'.$query.'%',
																					'Titular.cnpj LIKE'=>'%'.$cnpj.'%'
																				)
																			),
															'order' => 'nome ASC'
														)
											);
		
			foreach ($titulares as $titular) {
				array_push($resultado['aaData'], array(
													"<a href='./titulares/view/".$titular['Titular']['id']."'>". (!empty($titular['Titular']['cnpj']) ? sprintf("%s.%s.%s/%s-%s : ", substr($titular['Titular']['cnpj'],0,2), substr($titular['Titular']['cnpj'],2,3), substr($titular['Titular']['cnpj'],5,3), substr($titular['Titular']['cnpj'],8,4), substr($titular['Titular']['cnpj'],-2)) : '').$titular['Titular']['nome']."</a>"
												)
					);
			}
			$resultado['iTotalDisplayRecords'] = sizeof($titulares);
		}else{
			$titulares =  $this->Titular->find('all',array('limit'=>$limit,
														  'conditions'=>array('Titular.id >'=>($sEcho-1)*$limit),
														  'order' => 'nome ASC'
														  )
											);

			foreach ($titulares as $titular) {
				array_push($resultado['aaData'], array("<a href='./titulares/view/".$titular['Titular']['id']."'>". (!empty($titular['Titular']['cnpj']) ? sprintf("%s.%s.%s/%s-%s : ", substr($titular['Titular']['cnpj'],0,2), substr($titular['Titular']['cnpj'],2,3), substr($titular['Titular']['cnpj'],5,3), substr($titular['Titular']['cnpj'],8,4), substr($titular['Titular']['cnpj'],-2)) : '').$titular['Titular']['nome']."</a>"
												)
													
					);
			}
			$resultado['iTotalDisplayRecords'] = $this->Titular->find('count');
		}
		echo json_encode($resultado);
	}
}
?>