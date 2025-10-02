<?php
class InventoresController extends AppController {

	var $name = 'Inventores';
	
	var $paginate = array(
		'limit' => 100,
		'fields' => array('Inventor.id', 'Inventor.nome'),
		'order' => array('Inventor.nome' => 'asc'),
		'recursive' => 1
	);
	
	function index() {		
		$inventores = $this->paginate();
		$this->set('inventores', $inventores);
	}
	
	function listar($excel='') {			
		$this->Inventor->recursive = -1;
		
		$query = "SELECT i.id AS id, i.nome AS nome, count(it.inventor_id) AS total
		FROM inventores i LEFT JOIN inventores_tecnologias it
		ON i.id = it.inventor_id GROUP BY i.id
		ORDER BY total DESC, nome ASC";
		
		$inventores = $this->Inventor->query($query);
		// print_r($inventores);exit;		
		
		if ($excel) {
			$saida = '';
			foreach ($inventores as $inventor) {
				$saida .= sprintf("%s,%d\n", $inventor['i']['nome'], $inventor[0]['total']);
			}
			echo $saida;
			exit;			
		}		
		
		$this->set('inventores', $inventores);
	}
	
	function excel() {
		$this->Inventor->recursive = -1;
		
		$query = "SELECT i.id AS id, i.nome AS nome, count(it.inventor_id) AS total
		FROM inventores i LEFT JOIN inventores_tecnologias it
		ON i.id = it.inventor_id GROUP BY i.id
		ORDER BY total DESC, nome ASC";
		
		$inventoresTmp = $this->Inventor->query($query);
		
		$inventores = array();
		
		for($i=0;$i<count($inventoresTmp);$i++) {
			$inventores[$i]['nome'] 	= $inventoresTmp[$i]['i']['nome'];
			$inventores[$i]['total']	= $inventoresTmp[$i][0]['total'];
		}
		
		// print_r($inventores);exit;
		
		$this->layout = 'ajax';
    $this->set('inventores', $inventores);
  }
	
	// funcao q lista inventores utilizando o metodo de recursividade extrema e o SET depois
	function listarLento($excel='') {			
		$inventores = $this->Inventor->find('all');	
		// print_r($inventores);exit;
				
		$tmp = array();
		for($i=0;$i<count($inventores);$i++) {
			$tmp[$i]['nome'] = $inventores[$i]['Inventor']['nome'];
			$tmp[$i]['id'] = $inventores[$i]['Inventor']['id'];
			$tmp[$i]['tecnologias'] = count($inventores[$i]['Tecnologia']);
		}
		
		$inventores = Set::sort($tmp, '{n}.tecnologias', 'desc');
		
		if ($excel) {
			$saida = '';
			foreach ($inventores as $inventor) {
				$saida .= sprintf("%s,%d\n", $inventor['nome'], $inventor['tecnologias']);
			}
			echo $saida;
			exit;			
		}
		
		$this->set('inventores', $inventores);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid inventor', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Inventor->recursive = 2;
		
 		$options['conditions'] = array(
			"Inventor.id = $id"
		);
		
		$inventor = $this->Inventor->find('first', $options );
		$this->set('inventor',$inventor);
	}

	function add() {
		if (!empty($this->data)) {
			//print_r($this->data);
			//exit();
			
			$nome = $this->data['Inventor']['nome'];
			$this->data['Inventor']['cpf'] = preg_replace('/[^0-9]+/', '', $this->data['Inventor']['cpf']);
			$cpf = $this->data['Inventor']['cpf'];
			
			$existeNome = $this->Inventor->findByNome($nome);
			$existeCpf = $this->Inventor->findByCpf($cpf);
			
			if ($existeNome || $existeCpf) {
				$this->Session->setFlash('Já há no sistema um inventor com este nome ou CPF');	
				$this->redirect(array('action' => 'add'));exit;
			}
			$this->Inventor->create();
			if ($this->Inventor->save($this->data)) {
				$this->Session->setFlash(__('The inventor has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The inventor could not be saved. Please, try again.', true));
			}
		}
		$this->set(compact('tecnologias'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid inventor', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->data['Inventor']['cpf'] = preg_replace('/[^0-9]+/', '', $this->data['Inventor']['cpf']);
			if ($this->Inventor->save($this->data)) {
				$this->Session->setFlash(__('The inventor has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The inventor could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Inventor->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for inventor', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Inventor->delete($id)) {
			$this->Session->setFlash(__('Inventor deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Inventor was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function search() {		
		// se houve uma busca
		if (!empty($this->data)) {
			$condicoes = array(); // armazena as condicoes da busca
			$options   = array(); // será passada para a funcao 
		
			$nome = $this->data['Inventor']['nome'];

			$this->data['Inventor']['cpf'] = preg_replace('/[^0-9]+/', '', $this->data['Inventor']['cpf']);
			$cpf = $this->data['Inventor']['cpf'];
		
			if (!empty($nome)) {
				$condicoes['Inventor.nome LIKE'] = '%'.$nome.'%';
			}

			if (!empty($cpf)) {
				$condicoes['Inventor.cpf LIKE'] = '%'.$cpf.'%';
			}
		
			$options['order'] = array(
	        'Inventor.nome' => 'asc'
	    );
	
			$options['conditions'] = $condicoes;			
			$inventores = $this->Inventor->find('all', $options );
			$this->set('inventores',$inventores);
		}
		
	}

	function documentos($id) {		
		if (!$id) {
			$this->Session->setFlash(__('Invalid inventor', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Inventor->recursive = 2;
		
		$options['conditions'] = array(
			"Inventor.id = $id"
		);
		
		$inventor = $this->Inventor->find('first', $options );
		$this->set('inventor',$inventor);
	
	}

	function coautoria() {
		
		$min = 1;
		$max = 20;
		$this->autoRender = false;		
		
		$id1=1;
		$id2=0;
		$count = 0;
		for($id1;$id1<$max;$id1++){
			$id2=$id1+1;
			for($id2;$id2<$max;$id2++){
				if($id1!=$id2){
					$n = count ($inventores = $this->Inventor->query("SELECT * FROM inventores_tecnologias WHERE inventor_id = $id1 AND tecnologia_id in (
																SELECT tecnologia_id FROM inventores_tecnologias WHERE inventor_id = $id2)"
															)
						); 
					$count++;
					printf("%d   &nbsp&nbsp&nbsp&nbsp   %d  &nbsp&nbsp&nbsp&nbsp    %d  &nbsp&nbsp&nbsp&nbsp    %d<br>",$count,$id1,$id2,$n);
				}
			}

		}
	}
	
}
?>