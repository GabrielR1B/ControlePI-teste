<?php
class PalavraschaveController extends AppController {

	var $paginate = array(
		'limit' => 100,
		'fields' => array('Palavrachave.id', 'Palavrachave.palavra'),
		'order' => array('Palavrachave.palavra' => 'asc'),
		'recursive' => 1
	);
	
	function index() {		
		$palavraschave = $this->paginate();
		$this->set('palavraschave', $palavraschave);
	}
	
	function listar($excel='') {			
		$this->Palavrachave->recursive = -1;
		
		$query = "SELECT p.id AS id, p.palavra AS palavra, count(pt.palavrachave_id) AS total
		FROM palavraschave p LEFT JOIN palavraschave_tecnologias pt
		ON p.id = pt.palavrachave_id GROUP BY p.id
		ORDER BY total DESC, palavra ASC";
		
		$palavraschave = $this->Palavrachave->query($query);
		
		if ($excel) {
			$saida = '';
			foreach ($palavraschave as $palavrachave) {
				$saida .= sprintf("%s,%d\n", $palavrachave['p']['palavra'], $palavrachave[0]['total']);
			}
			echo $saida;
			exit;			
		}		
		
		$this->set('palavraschave', $palavraschave);
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
			$this->Session->setFlash(__('ID inválido', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Palavrachave->recursive = 2;
		
		$options['conditions'] = array(
			"Palavrachave.id = $id"
		);
		
		$palavrachave = $this->Palavrachave->find('first', $options );
		// debug($palavrachave);
		$this->set('palavrachave',$palavrachave);
	}

	function add() {
		if (!empty($this->data)) {
			$this->Palavrachave->create();
	
			$this->data['Palavrachave']['palavra'] = mb_strtoupper($this->data['Palavrachave']['palavra']);

			if ($this->Palavrachave->save($this->data)) {
				$this->Session->setFlash(__('Palavra-chave adicionada com sucesso', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Não foi possível salvar a palavra-chave. Por favor tente novamente.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('ID inválido', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Palavrachave->save($this->data)) {
				$this->Session->setFlash(__('Palavra-chave salva com sucesso', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Não foi possível salvar a palavra-chave. Por favor tente novamente.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Palavrachave->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('ID inválido', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Palavrachave->delete($id)) {
			$this->Session->setFlash(__('Palavra-chave excluída', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Palavra-chave não excluída', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function search() {		
		// se houve uma busca
		if (!empty($this->data)) {
			$condicoes = array(); // armazena as condicoes da busca
			$options   = array(); // será passada para a funcao 
			$palavra   = $this->data['Palavrachave']['palavra'];
			
			if (!empty($palavra)) {
				$condicoes['Palavrachave.palavra LIKE'] = '%'.$palavra.'%';
			}
		
			$options['order'] = array(
	        'Palavrachave.palavra' => 'asc'
	    );
	
			$options['conditions'] = $condicoes;			
			$palavraschave = $this->Palavrachave->find('all', $options );
			$this->set('palavraschave',$palavraschave);
		}
		
	}

	function ajaxSearch() {
		$query = $_GET['q'];

		$palavraschave = null;

		if (!empty($query)) {
			$condicoes = array(); // armazena as condicoes da busca
			$options   = array(); // será passada para a funcao 
			
			$this->layout = '';
			$this->Palavrachave->recursive = -1;
			
			if (!empty($query)) {
				$condicoes['Palavrachave.palavra LIKE'] = '%'.$query.'%';
			}
		
			$options['order'] = array(
	        	'Palavrachave.palavra' => 'asc'
	    	);

	    	$options['limit'] = 10;
	
			$options['conditions'] = $condicoes;			
			$palavrasChave = $this->Palavrachave->find('all', $options );
			
		}

		$this->set('palavrasChave',$palavrasChave);
	}
	
}
?>