<?php
require 'vendors/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TecnologiasController extends AppController {

	var $name = 'Tecnologias';
	var $components = array('Upload');
	var $helpers = array('Form2'); 

	public function beforeFilter() {
		parent::beforeFilter();
	}

	var $paginate = array(
		'limit' => 50,
		'order' => array(
			'Tecnologia.data' => 'desc',
			'Tecnologia.num_pedido' => 'desc'
		)
	);
	
	function index() {
		$this->Tecnologia->recursive = 1;
		$tecnologias = $this->paginate('Tecnologia', array("Tecnologia.pais_id = 2"));
		$inventores = $this->Tecnologia->Inventor->find('list');

		$this->set(compact('tecnologias', 'inventores'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid tecnologia', true));
			$this->redirect(array('action' => 'index'));
		}

		$this->Tecnologia->recursive = 1;
		$this->Tecnologia->Pais->recursive = 0;
		$tecnologia = $this->Tecnologia->read(null, $id);

		$paises = $this->Tecnologia->Pais->find('all');
		$paises = Set::combine($paises, '{n}.Pais.id', '{n}.Pais');

		$publicacoes = $this->Tecnologia->Publicacao->find('all',array('conditions'=>array('Tecnologia.id'=>$id)));

		$this->loadModel('Documento');
		$tipos_documentos = $this->Documento->find('list');

		$patentes_relacionadas = array();
		$patentes_relacionadas = array_merge($patentes_relacionadas,$tecnologia['PatenteInternacional']);

		if(isset($tecnologia['PrioridadeInterna']['id']))
		{
			$tecnologia['PrioridadeInterna']['prioridade_interna'] = true;
			array_push($patentes_relacionadas, $tecnologia['PrioridadeInterna']);
		}

		//Busca os certificados de adição da patente
		foreach ($this->Tecnologia->findAllByPatenteOriginalId($id) as $certificado)
		{
			$certificado['Tecnologia']['certificado_adicao'] = true;
			array_push($patentes_relacionadas, $certificado['Tecnologia']);
		}

		//Busca a patente mãe do certificado de adição
		if(isset($tecnologia['Tecnologia']['patente_original_id']))
		{
			$patente_original = $this->Tecnologia->findById($tecnologia['Tecnologia']['patente_original_id']);
			$patente_original['Tecnologia']['patente_original'] = true;
			array_push($patentes_relacionadas, $patente_original['Tecnologia']);
		}

		//print_r($patentes_relacionadas);
		//exit();
		
		$this->set('tecnologia', $tecnologia);
		$this->set('publicacoes', $publicacoes);
		$this->set('paises', $paises);
		$this->set('tipos_documentos', $tipos_documentos);
		$this->set('patentes_relacionadas', $patentes_relacionadas);
		$this->Set('naturezas',$this->Tecnologia->PatenteInternacional->NaturezaPatenteInternacional->find('list'));
		if(!empty($titulos))$this->set('titulos', $titulos);
		if(!empty($categorias))$this->set('categorias', $categorias);
	}

	function add() {
		if (!empty($this->data)) {

			$prioridade = $this->Tecnologia->findById($this->data['Tecnologia']['prioridade_interna_id']);
			if ($prioridade['Tecnologia']['prioridade_interna_id'] != null) {
				$this->Session->setFlash(__('A patente selecionada já está vinculada como prioridade interna a uma outra tecnologia.', true));
				$this->redirect(array('action' => 'index'));
				exit();
			}

			if ($this->Tecnologia->save($this->data)) {

				if($prioridade){
					$this->Tecnologia->save(
						array('Tecnologia'=>array(
											'id' => $prioridade['Tecnologia']['id'],
											'prioridade_interna_id' => $this->Tecnologia->id
											)
						)
					);
				}

				$this->Session->setFlash(__('The tecnologia has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tecnologia could not be saved. Please, try again.', true));
			}
		}
		$naturezatecnologias = $this->Tecnologia->NaturezaTecnologia->find('list'); 
		$areas = $this->Tecnologia->Area->find('list');
		$areas_conhecimento = $this->Tecnologia->AreaConhecimento->find('list',array('order'=>'nome ASC'));
		$status = $this->Tecnologia->Status->find('list');
		$inventores = $this->Tecnologia->Inventor->find('list');
		$redatores = $this->Tecnologia->Redator->find('list');
		$paises = $this->Tecnologia->Pais->find('list');

		$this->set(compact('areas','areas_conhecimento', 'status', 'inventores','redatores','naturezatecnologias','paises'));
	}

	function edit($id = null) {
		
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid tecnologia', true));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {

			//Verifica se a prioridade interna escolhida pode ser persistida no banco de dados
			$prioridadeant = $this->Tecnologia->findById($this->data['Tecnologia']['prioridade_interna_id']); //Prioridade Interna que está sendo adicionada
			$tecnologia = $this->Tecnologia->findById($this->Tecnologia->id); //Busca os dados da tecnoligia sendo editada no banco de dados
			$prioridadebanco = $tecnologia['PrioridadeInterna']['id'];	//Armazena o id da prioridade já existente no banco de dados	
			if (($prioridadeant['Tecnologia']['prioridade_interna_id'] != null) && ($prioridadeant['Tecnologia']['id'] != $prioridadebanco)) {
				$this->Session->setFlash(__('A patente já possui uma anterioridade cadastrada. Não é possível cadastrar 2 prioridades para a mesma patente.', true));
				$this->redirect(array('action' => 'index'));
			}

			if ($this->Tecnologia->save($this->data)) {


				if($this->data['Tecnologia']['prioridade_interna_id'] == NULL){
					
					$prioridade_interna_id = $tecnologia['PrioridadeInterna']['id'];

					$prioridade = array('Tecnologia'=>array(
														'id' => $prioridade_interna_id,
														'prioridade_interna_id' => null
														)
								);
					$this->Tecnologia->query('UPDATE tecnologias SET prioridade_interna_id = NULL WHERE prioridade_interna_id = '.$id);
				}else{
					$prioridade = array('Tecnologia'=>array(
														'id' => $this->data['Tecnologia']['prioridade_interna_id'],
														'prioridade_interna_id' => $this->Tecnologia->id
														)
								);
					$this->Tecnologia->save($prioridade);
				}

				//Trata os certificados de adição
				$tecnologia_id = $this->data['Tecnologia']['id'];
				$ids_certificados_adicao = explode(',',$this->data['Tecnologia']['certificado_adicao_id']);
				$this->Tecnologia->query('UPDATE tecnologias SET patente_original_id = null WHERE patente_original_id = ' . $tecnologia_id);
				foreach ($ids_certificados_adicao as $id) {
					if($id != '')
						$this->Tecnologia->query('UPDATE tecnologias SET patente_original_id =' . $tecnologia_id . ' WHERE id = ' . $id);
				}

				$this->Session->setFlash(__('The tecnologia has been saved', true));
				$this->redirect(array('action' => 'view', $tecnologia_id));
			} else {
				$this->Session->setFlash(__('The tecnologia could not be saved. Please, try again.', true));
			}
		}else{
			$this->data = $this->Tecnologia->read(null, $id);
		}

		$tecnologia = $this->Tecnologia->read(null, $id);
		$titulares = $tecnologia['Titular'];
		$departamentos = $tecnologia['Departamento'];
		$inventores = $tecnologia['Inventor']; // pega somente os inventores no array associativo.
		$empresas = $tecnologia['Empresa']; 

		$acompanhamentos = $this->Tecnologia->Titular->find('list', array('order' => 'nome ASC'));	// pega os statsu para popular o select
		
		$palavraschave = $tecnologia['Palavrachave']; // pega somente os inventores no array associativo.		
		$arquivos = $tecnologia['Arquivo']; // pega somente os arquivos no array associativo.
		$paises = $this->Tecnologia->Pais->find('list');
		$unidades = $this->Tecnologia->Unidade->find('list');
		$naturezas = $this->Tecnologia->NaturezaTecnologia->find('list'); 	
		$areas      = $this->Tecnologia->Area->find('list'); 			// pega as áreas para popular o select
		$areas_conhecimento = $this->Tecnologia->AreaConhecimento->find('list',array('order'=>'nome ASC'));
		$andamentos = $this->Tecnologia->Andamento->find('list');
		$status	= $this->Tecnologia->Status->find('list');	// pega os status para popular o select
		$redatores = $this->Tecnologia->Redator->find('list', array('order' => 'nome ASC'));

		$this->loadModel('Documento');
		$tipos_documentos = $this->Documento->find('list');

		$tecnologia_id = $id; // envia o ID da tecnologia para o view permitindo o acesso via JS

		//Cria um json com os certificados de adição da patente que está sendo editada. 
		//É utilizado para popular o campo Certificados de Adição na view
		$certificados = array();
		foreach ($this->Tecnologia->findAllByPatenteOriginalId($tecnologia_id) as $certificado)
		{
			array_push($certificados, array('id'=>$certificado['Tecnologia']['id'], 'name'=>$certificado['Tecnologia']['titulo'], 'num_pedido'=>$certificado['Tecnologia']['num_pedido']));
		}
		$certificados = json_encode($certificados);


		$this->set(compact('tecnologia', 'titulares','unidades','departamentos','acompanhamentos','naturezas','paises','areas', 'areas_conhecimento', 'andamentos', 'status', 'status_transferencia', 'inventores', 'empresas', 'palavraschave', 'tecnologia_id', 'arquivos','tipos_documentos','redatores','certificados'));
	}

	function editar_participacao($id = null) {
		$this->loadModel('TecnologiaTitular');
		
		if (!empty($this->data)) {
			$this->TecnologiaTitular->save($this->data);
			$tecnologia_titular = $this->TecnologiaTitular->findById($id);
			if($this->data['TecnologiaTitular']['percentual'] > 100 || $this->data['TecnologiaTitular']['percentual'] < 0)
			{
				$this->Session->setFlash(__('Percentual inválido', true));
				$this->redirect(array('action' => 'editar_participacao', $id));
			}

			$tecnologia_titular['TecnologiaTitular']['percentual'] = $this->data['TecnologiaTitular']['percentual'];
			$this->redirect(array('action' => 'edit', $tecnologia_titular['TecnologiaTitular']['tecnologia_id']));
		}
		
		$this->data = $this->TecnologiaTitular->read(null, $id);

		$tecnologias = $this->Tecnologia->find('list');
		$titulares = $this->Tecnologia->Titular->find('list');

		$this->set(compact('tecnologias','titulares'));
	}

	// Função que edita categoria e titulo à época de todos os inventores da tecnologia.
	function editAllInv($id = null) { // Recebe o id da tecnologia

		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid tecnologia', true));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {
			if ($this->Tecnologia->save($this->data)) {
				$this->Session->setFlash(__('As alterações foram salvas com sucesso!', true));
				$this->redirect(array('action' => 'edit', $id));
			} else {
				$this->Session->setFlash(__('As alterações não foram salvas. Por favor, tente novamente.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Tecnologia->read(null, $id);	
		}

		$tecnologia = $this->Tecnologia->read(null, $id);
		$inventores = $tecnologia['Inventor'];
		$categorias = $this->Tecnologia->Inventor->Categoria->find('list', array('order' => 'nome ASC'));
		$titulos = $this->Tecnologia->Inventor->Titulo->find('list', array('order' => 'nome ASC'));
		$this->set(compact('inventores', 'categorias', 'titulos'));
	}

	function edit_documentos($id = null) {
		
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid tecnologia', true));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {
			if ($this->Tecnologia->save($this->data)) {
				$this->Session->setFlash(__('The tecnologia has been saved', true));
				$this->redirect(array('action' => 'edit', $id));
			} else {
				$this->Session->setFlash(__('The tecnologia could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Tecnologia->read(null, $id);	
		}

		$tecnologia = $this->Tecnologia->read(null, $id);
		// print_r($tecnologia);exit;
		// busca os inventores associados a tecnologia em edição
		$inventores = $tecnologia['Inventor']; // pega somente os inventores no array associativo.
		// busca as palavras-chave associadas a tecnologia em edição
		$palavraschave = $tecnologia['Palavrachave']; // pega somente os inventores no array associativo.		
		
		$arquivos = $tecnologia['Arquivo']; // pega somente os arquivos no array associativo.		
		
		$naturezatecnologias = $this->Tecnologia->NaturezaTecnologia->find('list'); 	
		$areas      = $this->Tecnologia->Area->find('list'); 			// pega as áreas para popular o select
		$status		  = $this->Tecnologia->Status->find('list');	// pega os statsu para popular o select
		
		$tecnologia_id = $id; // envia o ID da tecnologia para o view permitindo o acesso via JS

		$this->set(compact('tecnologia','naturezatecnologias','areas', 'status', 'inventores', 'palavraschave', 'tecnologia_id', 'arquivos'));
	}

	function internacional() {

		$paginate = array(             
		 				'order' => array(            
		 								'Tecnologia.data' => 'asc'        
		 								)    
		 				);

		//var_dump($lastmonth);exit;
		$this->Tecnologia->recursive = 1;
		$tecnologias = $this->paginate('Tecnologia', array("Tecnologia.pais_id NOT LIKE 2"));
		//$inventores = $this->Tecnologia->Inventor->find('list');
		$paises = $this->Tecnologia->Pais->find('all');

				
		$this->set(compact('tecnologias', 'inventores','paises'));
	}

	function pct() {

		$paginate = array(             
		 						'order' => array(            
		 										'Tecnologia.data' => 'asc'        
		 										)    
		 					);

		//var_dump($lastmonth);exit;
		$this->Tecnologia->recursive = 1;
		//$tecnologias = $this->paginate('Tecnologia', array("DATE_ADD(Tecnologia.data, INTERVAL 360 DAY) > DATE_SUB(NOW(), INTERVAL 60 DAY)", "DATE_ADD(Tecnologia.data, INTERVAL 360 DAY) < DATE_ADD(NOW(), INTERVAL 60 DAY)"));
		$tecnologias = $this->paginate('Tecnologia', array("SELECT YEAR(data) as ano, MONTH(data) as mes, COUNT(*) as total from tecnologias WHERE data > DATE_SUB(NOW(), INTERVAL 10 YEAR) GROUP BY YEAR(data), MONTH(data)"));
		$inventores = $this->Tecnologia->Inventor->find('list');

				
		$this->set(compact('tecnologias', 'inventores'));
	}
	
	function desassociarInventor($idTec = null, $idInventor = null) {
		if (!$idTec || !$idInventor) {
			$this->Session->setFlash(__('Invalid tecnologia', true));
			$this->redirect(array('action' => 'index'));
		}
		
		$query = sprintf("DELETE FROM inventores_tecnologias WHERE tecnologia_id = %d AND inventor_id = %d LIMIT 1", $idTec, $idInventor);
		$resultado = $this->Tecnologia->query($query);
				
		$this->Session->setFlash(__('Inventor desassociado com sucesso', true));
		$this->redirect(array('action' => 'view', $idTec));
	}
	
	function excluirArquivo($idTec = null, $idArquivo = null) {
		if (!$idTec || !$idArquivo) {
			$this->Session->setFlash('Arquivo inválido!');
			$this->redirect(array('action' => 'index'));
		}
		
		$this->Tecnologia->Arquivo->delete($idArquivo);
				
		$this->Session->setFlash('Arquivo excluído com sucesso');
		$this->redirect(array('action' => 'view', $idTec));
	}

	function getTokens($term){
		$regex = '%"(.*?)"|[a-zA-ZÀ-ÿ\(][^ ]*%';
		$hits = preg_match_all($regex,$term,$matches,PREG_PATTERN_ORDER);

		$resultado = [];
		foreach ($matches[0] as $match) {
			array_push($resultado,$match);
		}

		return $resultado;
	}

	function hasOperator($tokens){
		foreach ($tokens as $token) {
			if($this->isOperator($token)){
				return true;
			}
		}

		return false;
	}

	function checkTokens($tokens)
	{
		if(!$this->hasOperator($tokens)){
			return false;
		}

		//Checa se a quantidade de tokens está certa
		if(strtoupper($tokens[0]) == "NOT"){
			if((count($tokens) % 2) != 0)
			{
				$this->Session->setFlash('Consulta mal formada', true);
				$this->redirect(array('action'=>'search'));
			}
		}else{
			if((count($tokens) % 2) == 0)
			{
				$this->Session->setFlash('Consulta mal formada', true);
				$this->redirect(array('action'=>'search'));
			}
		}

		//Checa se os operadores estão nas posições certas
		for($i = 0; $i < count($tokens); $i++){
			if(strtoupper($tokens[0]) == "NOT"){
				if($i % 2 == 0){
					if(!$this->isOperator($tokens[$i])){
						$this->Session->setFlash('Consulta mal formada'.$tokens[$i], true);
						$this->redirect(array('action'=>'search'));
					}
				}else{
					if($this->isOperator($tokens[$i])){
						$this->Session->setFlash('Consulta mal formada'.$tokens[$i], true);
						$this->redirect(array('action'=>'search'));
					}
				}
			}else{
				if($i % 2 == 0){
					if($this->isOperator($tokens[$i])){
						$this->Session->setFlash('Consulta mal formada'.$tokens[$i], true);
						$this->redirect(array('action'=>'search'));
					}
				}else{
					if(!$this->isOperator($tokens[$i])){
						$this->Session->setFlash('Consulta mal formada'.$tokens[$i], true);
						$this->redirect(array('action'=>'search'));
					}
				}
			}
		}

		return true;
	}

	function isOperator($term){
		$operators = ["AND","OR","NOT"];

		foreach ($operators as $key => $operator) {
			if(strtoupper($term) == $operator){
				return true;
			}
		}

		return false;
	}

	function getPairs($tokens){
		$pairs = [];
		if(strtoupper($tokens[0])=="NOT"){
			for ($i=0; $i < count($tokens) ; $i+=2) { 
				array_push($pairs, array($tokens[$i],$tokens[$i+1]));
			}
		}else{
			$new_tokens = [];
			$new_tokens[0] = "";
			for ($i=0; $i < count($tokens) ; $i++) { 
				$new_tokens[$i+1] = $tokens[$i];
			}
			$tokens = $new_tokens;

			for ($i=0; $i<count($tokens); $i+=2) { 
				array_push($pairs, array($tokens[$i],$tokens[$i+1]));
			}
		}

		return $pairs;
	}

	function getPairsNoOperators($tokens){
		$result = [];
		foreach ($tokens as $key => $token) {
			if($key == 0){
				$result[0][0] = '';
				$result[0][1] = $token;
			}else{
				$result[$key][0] = 'AND';
				$result[$key][1] = $token;
			}
		}

		return $result;
	}
	
	function search() {		
		set_time_limit(300);
		if (!empty($this->data)) {
			//debug($this->data);
			//exit();
			
			$condicoes = array(); // armazena as condicoes da busca
			$options   = array(); // será passada para a funcao 
		
			$titulo = $this->data['Tecnologia']['titulo'];
			$resumo = $this->data['Tecnologia']['resumo'];
			$num_reivindicacoes = $this->data['Tecnologia']['num_reivindicacoes'];
			$reivindicacoes = $this->data['Tecnologia']['reivindicacoes'];
			$num_pedido = $this->data['Tecnologia']['num_pedido'];
			$pasta = $this->data['Tecnologia']['pasta'];
			$pasta_juridico = $this->data['Tecnologia']['pasta_juridico'];
			$area_id = $this->data['Tecnologia']['area_id'];
			$num_processo_sei = $this->data['Tecnologia']['num_processo_sei'];
			$area_conhecimento_id = $this->data['Tecnologia']['area_conhecimento_id'];
			$status_id = $this->data['Tecnologia']['status_id'];
			$status_transferencia_id = $this->data['Tecnologia']['status_transferencia_id'];
			$titular_id = $this->data['Tecnologia']['titular_id'];
			$acompanhamento_id = $this->data['Tecnologia']['acompanhamento_id'];
			$unidade_id  = $this->data['Tecnologia']['unidade_id'];
			$departamento_id  = $this->data['Tecnologia']['departamento_id'];
			$andamento_id = $this->data['Tecnologia']['andamento_id'];
			$inventor_id = $this->data['Inventor']['Inventor'];
			$anoDe = $this->data['Tecnologia']['desde'];
			$anoAte = $this->data['Tecnologia']['ate'];
			$mesDe = $this->data['Tecnologia']['mesDe'];
			$mesAte = $this->data['Tecnologia']['mesAte'];
			$prioridade_interna = $this->data['Tecnologia']['prioridade_interna'];
			$tem_pct = $this->data['Tecnologia']['pct'];
			$redator_id = $this->data['Tecnologia']['redator_id'];

			if($this->data['Tecnologia']['palavrachave']!=''){
				$palavras_chave = explode(',',$this->data['Tecnologia']['palavrachave']);	
			}		
		
			//Busca por título
			if (!empty($titulo)) {
			 	$tokens_titulo = $this->getTokens($titulo);
			 	if(!$this->checkTokens($tokens_titulo)){
			 		$pairs = $this->getPairsNoOperators($tokens_titulo);
			 	}else{
			 		$pairs = $this->getPairs($tokens_titulo);
			 	}
			 	
			 	//Aplica todos os operadores NOT
			 	foreach ($pairs as $key => $pair) {
			 		if(strtoupper($pair[0]) == "NOT"){
			 			if(isset($condicoes['NOT'])){
			 				array_push($condicoes['NOT'], array('Tecnologia.titulo LIKE' => '%'.$pair[1].'%'));
			 			}else{
			 				$condicoes['NOT'] = [];
			 				array_push($condicoes['NOT'], array('Tecnologia.titulo LIKE' => '%'.$pair[1].'%'));
			 			}
			 			unset($pairs[$key]);
			 		}
			 	}

			 	//Monta a árvore de operadores AND e OR
			 	if(count($pairs) == 1){
			 		$condicoes['Tecnologia.titulo LIKE'] = '%'.$pairs[0][1].'%';
			 	}else if(count($pairs) == 2){
			 		$condicoes[$pairs[1][0]] = array(array('Tecnologia.titulo LIKE' => '%'.$pairs[0][1].'%'), array('Tecnologia.titulo LIKE' => '%'.$pairs[1][1].'%'));
			 	}else if(count($pairs) == 3){
			 		$condicoes[$pairs[1][0]] = array(
			 			array('Tecnologia.titulo LIKE' => '%'.$pairs[0][1].'%'), 
			 			$pairs[2][0] => array(array('Tecnologia.titulo LIKE' => '%'.$pairs[1][1].'%'),array('Tecnologia.titulo LIKE' => '%'.$pairs[2][1].'%')));
			 	}else if(count($pairs) == 4){
			 		$condicoes[$pairs[1][0]] = array(
			 			array('Tecnologia.titulo LIKE' => '%'.$pairs[0][1].'%'), 
			 				$pairs[2][0] => array(array('Tecnologia.titulo LIKE' => '%'.$pairs[1][1].'%'),
			 								  array($pairs[3][0] =>array('Tecnologia.titulo LIKE' => '%'.$pairs[2][1].'%','Tecnologia.titulo LIKE' => '%'.$pairs[3][1].'%'))
			 			)
			 		);
			 	}else if(count($pairs) >= 5){
			 		$condicoes[$pairs[1][0]] = array(
			 			array('Tecnologia.titulo LIKE' => '%'.$pairs[0][1].'%'), 
			 				$pairs[2][0] => array(array('Tecnologia.titulo LIKE' => '%'.$pairs[1][1].'%'),
			 								  	  array($pairs[3][0] =>array(array('Tecnologia.titulo LIKE' => '%'.$pairs[2][1].'%'), 
			 								  							     array($pairs[4][0] => array(array('Tecnologia.titulo LIKE' => '%'.$pairs[3][1].'%'),array('Tecnologia.titulo LIKE' => '%'.$pairs[4][1].'%')))))
			 			)
			 		);
			 	}
			}

			// Busca por resumo
			if (!empty($resumo)) {
			 	$tokens_resumo = $this->getTokens($resumo);
			 	if(!$this->checkTokens($tokens_resumo)){
			 		$pairs = $this->getPairsNoOperators($tokens_resumo);
			 	}else{
			 		$pairs = $this->getPairs($tokens_resumo);
			 	}
			 	
			 	//Aplica todos os operadores NOT
			 	foreach ($pairs as $key => $pair) {
			 		if(strtoupper($pair[0]) == "NOT"){
			 			if(isset($condicoes['NOT'])){
			 				array_push($condicoes['NOT'], array('Tecnologia.resumo LIKE' => '%'.$pair[1].'%'));
			 			}else{
			 				$condicoes['NOT'] = [];
			 				array_push($condicoes['NOT'], array('Tecnologia.resumo LIKE' => '%'.$pair[1].'%'));
			 			}
			 			unset($pairs[$key]);
			 		}
			 	}

			 	//Monta a árvore de operadores AND e OR
			 	if(count($pairs) == 1){
			 		$condicoes['Tecnologia.resumo LIKE'] = '%'.$pairs[0][1].'%';
			 	}else if(count($pairs) == 2){
			 		$condicoes[$pairs[1][0]] = array(array('Tecnologia.resumo LIKE' => '%'.$pairs[0][1].'%'), array('Tecnologia.resumo LIKE' => '%'.$pairs[1][1].'%'));
			 	}else if(count($pairs) == 3){
			 		$condicoes[$pairs[1][0]] = array(
			 			array('Tecnologia.resumo LIKE' => '%'.$pairs[0][1].'%'), 
			 			$pairs[2][0] => array(array('Tecnologia.resumo LIKE' => '%'.$pairs[1][1].'%'),array('Tecnologia.resumo LIKE' => '%'.$pairs[2][1].'%')));
			 	}else if(count($pairs) == 4){
			 		$condicoes[$pairs[1][0]] = array(
			 			array('Tecnologia.resumo LIKE' => '%'.$pairs[0][1].'%'), 
			 				$pairs[2][0] => array(array('Tecnologia.resumo LIKE' => '%'.$pairs[1][1].'%'),
			 								  array($pairs[3][0] =>array('Tecnologia.resumo LIKE' => '%'.$pairs[2][1].'%','Tecnologia.resumo LIKE' => '%'.$pairs[3][1].'%'))
			 			)
			 		);
			 	}else if(count($pairs) >= 5){
			 		$condicoes[$pairs[1][0]] = array(
			 			array('Tecnologia.resumo LIKE' => '%'.$pairs[0][1].'%'), 
			 				$pairs[2][0] => array(array('Tecnologia.resumo LIKE' => '%'.$pairs[1][1].'%'),
			 								  	  array($pairs[3][0] =>array(array('Tecnologia.resumo LIKE' => '%'.$pairs[2][1].'%'), 
			 								  							     array($pairs[4][0] => array(array('Tecnologia.resumo LIKE' => '%'.$pairs[3][1].'%'),array('Tecnologia.resumo LIKE' => '%'.$pairs[4][1].'%')))))
			 			)
			 		);
			 	}
			}

			//Busca por reivindicações
			if (!empty($reivindicacoes)) {
			 	$tokens_reivindicacoes = $this->getTokens($reivindicacoes);
			 	if(!$this->checkTokens($tokens_reivindicacoes)){
			 		$pairs = $this->getPairsNoOperators($tokens_reivindicacoes);
			 	}else{
			 		$pairs = $this->getPairs($tokens_reivindicacoes);
			 	}
			 	
			 	//Aplica todos os operadores NOT
			 	foreach ($pairs as $key => $pair) {
			 		if(strtoupper($pair[0]) == "NOT"){
			 			if(isset($condicoes['NOT'])){
			 				array_push($condicoes['NOT'], array('Tecnologia.reivindicacoes LIKE' => '%'.$pair[1].'%'));
			 			}else{
			 				$condicoes['NOT'] = [];
			 				array_push($condicoes['NOT'], array('Tecnologia.reivindicacoes LIKE' => '%'.$pair[1].'%'));
			 			}
			 			unset($pairs[$key]);
			 		}
			 	}

			 	//Monta a árvore de operadores AND e OR
			 	if(count($pairs) == 1){
			 		$condicoes['Tecnologia.reivindicacoes LIKE'] = '%'.$pairs[0][1].'%';
			 	}else if(count($pairs) == 2){
			 		$condicoes[$pairs[1][0]] = array(array('Tecnologia.reivindicacoes LIKE' => '%'.$pairs[0][1].'%'), array('Tecnologia.reivindicacoes LIKE' => '%'.$pairs[1][1].'%'));
			 	}else if(count($pairs) == 3){
			 		$condicoes[$pairs[1][0]] = array(
			 			array('Tecnologia.reivindicacoes LIKE' => '%'.$pairs[0][1].'%'), 
			 			$pairs[2][0] => array(array('Tecnologia.reivindicacoes LIKE' => '%'.$pairs[1][1].'%'),array('Tecnologia.reivindicacoes LIKE' => '%'.$pairs[2][1].'%')));
			 	}else if(count($pairs) == 4){
			 		$condicoes[$pairs[1][0]] = array(
			 			array('Tecnologia.reivindicacoes LIKE' => '%'.$pairs[0][1].'%'), 
			 				$pairs[2][0] => array(array('Tecnologia.reivindicacoes LIKE' => '%'.$pairs[1][1].'%'),
			 								  array($pairs[3][0] =>array('Tecnologia.reivindicacoes LIKE' => '%'.$pairs[2][1].'%','Tecnologia.reivindicacoes LIKE' => '%'.$pairs[3][1].'%'))
			 			)
			 		);
			 	}else if(count($pairs) >= 5){
			 		$condicoes[$pairs[1][0]] = array(
			 			array('Tecnologia.reivindicacoes LIKE' => '%'.$pairs[0][1].'%'), 
			 				$pairs[2][0] => array(array('Tecnologia.reivindicacoes LIKE' => '%'.$pairs[1][1].'%'),
			 								  	  array($pairs[3][0] =>array(array('Tecnologia.reivindicacoes LIKE' => '%'.$pairs[2][1].'%'), 
			 								  							     array($pairs[4][0] => array(array('Tecnologia.reivindicacoes LIKE' => '%'.$pairs[3][1].'%'),array('Tecnologia.reivindicacoes LIKE' => '%'.$pairs[4][1].'%')))))
			 			)
			 		);
			 	}
			}
		
			if (!empty($num_pedido)) {
				$condicoes['Tecnologia.num_pedido LIKE'] = '%'.$num_pedido.'%';
			}
			
			if (!empty($pasta)) {
				$condicoes['Tecnologia.pasta LIKE'] = '%'.$pasta.'%';
			}

			if (!empty($pasta_juridico)) {
				$condicoes['Tecnologia.pasta_juridico LIKE'] = '%'.$pasta_juridico.'%';
			}

			if (!empty($num_reivindicacoes)) {
				$condicoes['Tecnologia.num_reivindicacoes'] = $num_reivindicacoes;
			}
			
			if (!empty($num_processo_sei)) {
				$condicoes['Tecnologia.num_processo_sei LIKE'] = '%'.$num_processo_sei.'%';
			}
		
			if (!empty($area_id)) {
				$condicoes['Tecnologia.area_id'] = $area_id;
			}

			if (!empty($area_conhecimento_id)) {
				$condicoes['Tecnologia.area_conhecimento_id'] = $area_conhecimento_id;
			}

			if (!empty($status_id)) {
				$condicoes['Tecnologia.status_id'] = $status_id;
			}

			if (!empty($status_transferencia_id)) {
				$condicoes['Tecnologia.'.$status_transferencia_id] = '1';
			}

			if (!empty($acompanhamento_id)) {
				if($acompanhamento_id=='1')
				{
					$condicoes['Tecnologia.acompanhamento'] = '1';
				}else{
					$condicoes['Tecnologia.acompanhamento !='] = '1';
				}
			}

			$options['joins'] = array();

			if (!empty($titular_id)) {
				array_push($options['joins'],
					array('table' => 'tecnologias_titulares',
						'alias' => 'TecnologiasTitulares',
						'type' => 'inner',
						'conditions' => array(
							'Tecnologia.id = TecnologiasTitulares.tecnologia_id'
						)
					)
				);
				$condicoes['TecnologiasTitulares.titular_id'] = $titular_id;
			}

			if (!empty($unidade_id)) {
			
				array_push($options['joins'],
					array('table' => 'departamentos_tecnologias',
						'alias' => 'DepartamentosTecnologia',
						'type' => 'inner',
						'conditions' => array(
							'Tecnologia.id = DepartamentosTecnologia.tecnologia_id'
						)
					)
				);

				array_push($options['joins'],
					array('table' => 'unidades',
						'alias' => 'Unidade',
						'type' => 'inner',
						'conditions' => array(
							'DepartamentosTecnologia.unidade_id = Unidade.id'
						)
					)
				);
			
				$condicoes['Unidade.id'] = $unidade_id;
			}

			if (!empty($departamento_id)) {
				array_push($options['joins'],
					array('table' => 'departamentos_tecnologias',
						'alias' => 'DepartamentosTecnologia',
						'type' => 'inner',
						'conditions' => array(
							'Tecnologia.id = DepartamentosTecnologia.tecnologia_id'
						)
					)
				);

				array_push($options['joins'],
					array('table' => 'departamentos',
						'alias' => 'Departamento',
						'type' => 'inner',
						'conditions' => array(
							'DepartamentosTecnologia.departamento_id = Departamento.id'
						)
					)
				);

				$condicoes['Departamento.id'] = $departamento_id;
			}

			if(!empty($palavras_chave)){
				//debug($palavras_chave);
				//exit();
				$parametros = 'WHERE ';

				foreach ($palavras_chave as $palavra_id) {
					$parametros = $parametros.'palavrachave_id = '.$palavra_id.' OR ';
				}

				if($this->data['Tecnologia']['operador']){
					$parametros = substr_replace($parametros,'',-4);
					$parametros = $parametros.' GROUP BY tecnologia_id HAVING ocorrencias = '.sizeof($palavras_chave);
				}else{
					$parametros = substr_replace($parametros,'',-3);
					$parametros = $parametros.' GROUP BY tecnologia_id';
				}

				//echo "SELECT tecnologia_id, COUNT(tecnologia_id) AS ocorrencias FROM palavraschave_tecnologias ".$condicoes." ORDER BY ocorrencias DESC";
				$resultado = $this->Tecnologia->query("SELECT tecnologia_id, COUNT(tecnologia_id) AS ocorrencias FROM palavraschave_tecnologias ".$parametros);
				
				$ids = array();
				foreach ($resultado as $tecnologia) {
					array_push($ids,$tecnologia['palavraschave_tecnologias']['tecnologia_id']);
				}
				array_push($condicoes, array('Tecnologia.id'=>  $ids));


				$this->Tecnologia->Palavrachave->recursive = -1;
				$populate_palavras_chave = array();
				foreach ($this->Tecnologia->Palavrachave->find('all',array('conditions'=>array('Palavrachave.id'=>$palavras_chave))) as $palavra_chave){
					array_push($populate_palavras_chave,$palavra_chave['Palavrachave']);
				}
			}
			
			if (!empty($andamento_id)) {
				$condicoes['Tecnologia.andamento_id'] = $andamento_id;
			}

			if (!empty($redator_id)) {
				$condicoes['Tecnologia.redator_id'] = $redator_id;
			}

			if (!empty($prioridade_interna)) {
				$condicoes['NOT'] = array('Tecnologia.prioridade_interna_id' => null);
			}

			if (!empty($tem_pct)) {
				$query = "SELECT tecnologias.id FROM tecnologias JOIN patentes_internacionais_tecnologias ON tecnologias.id = patentes_internacionais_tecnologias.tecnologia_id JOIN patentes_internacionais ON patente_internacional_id = patentes_internacionais.id AND patentes_internacionais.natureza_id = 1";
				$resultado = $this->Tecnologia->query($query);
				$tecnologias_ids = Set::extract($resultado, "{n}.tecnologias.id");
				$condicoes['Tecnologia.id'] =  $tecnologias_ids;
			}


			$dataInicial = null;
			if (!empty($anoDe)) {
				if(!empty($mesDe)){
					$dataInicial = $anoDe . '-' . $mesDe . '-01';
				}else{
					$dataInicial = $anoDe . '-01-01';
				}
			}else{
				if(!empty($mesDe)){
					$this->Session->setFlash('Data mal formada. Escolha mês e ano.', true);
					$this->redirect(array('action'=>'search'));
				}
			}
			if($dataInicial){
				$condicoes['Tecnologia.data >='] = $dataInicial;
			}

			$dataFinal = null;
			if (!empty($anoAte)) {
				if(!empty($mesAte)){
					$dataFinal = $anoAte . '-' . $mesAte . '-01';
				}else{
					$dataFinal = $anoAte . '-01-01';
				}
			}else{
				if(!empty($mesAte)){
					$this->Session->setFlash('Data mal formada. Escolha mês e ano.', true);
					$this->redirect(array('action'=>'search'));
				}
			}
			if($dataFinal){
				$condicoes['Tecnologia.data <='] = $dataFinal;
			}

			if (!empty($inventor_id)) {
		
				$options['joins'] = array(
					array('table' => 'inventores_tecnologias',
						'alias' => 'InventoresTecnologia',
						'type' => 'inner',
						'conditions' => array(
							'Tecnologia.id = InventoresTecnologia.tecnologia_id'
						)
					),
					array('table' => 'inventores',
						'alias' => 'Inventor',
						'type' => 'inner',
						'conditions' => array(
							'InventoresTecnologia.inventor_id = Inventor.id'
						)
					)
				);
			
				$condicoes['Inventor.id'] = $inventor_id;

			}
		
			$options['order'] = array(
			'Tecnologia.data' => 'desc',
					'Tecnologia.num_pedido' => 'desc'
			);

			$options['group'] = array('Tecnologia.id');
	
			//A busca é realizada
			$options['conditions'] = $condicoes;
			//$options['limit'] = 50;
			$tecnologias = $this->Tecnologia->find('all', $options );

			//Busca os certificados de adição da patente
			for($i = 0; $i < count($tecnologias); $i++) {
				$certificados = $this->Tecnologia->findAllByPatenteOriginalId($tecnologias[$i]['Tecnologia']['id']);
				if(count($certificados) > 0){
					$tecnologias[$i]['Tecnologia']['tem_certificado_adicao'] = true;
				}else{
					$tecnologias[$i]['Tecnologia']['tem_certificado_adicao'] = false;
				}
			}

			$this->set('tecnologias',$tecnologias);

			$ids = Set::extract($tecnologias, "{n}.Tecnologia.id");
			$this->set('ids',json_encode($ids));
		}
		
		// Buscar inventores já associados a alguma tecnologia
		$params['joins'] = array(
			array('table' => 'inventores_tecnologias',
				'alias' => 'InventoresTecnologia',
				'type' => 'inner',
				'conditions' => array(
					'Inventor.id = InventoresTecnologia.inventor_id'
				)
			)
		);

		$params['order'] = array('Inventor.nome ASC');
		
		// group removido pois o list já faz um group
		// $params['group'] = array('Inventor.id');		
		$inventores = $this->Tecnologia->Inventor->find('list',$params);		
		// debug($inventores);

		$this->loadModel('Redator');
		$redatores = $this->Redator->fiNd('list');
		
		$areas = $this->Tecnologia->Area->find('list');
		$areas_conhecimento = $this->Tecnologia->AreaConhecimento->find('list');
		$status = $this->Tecnologia->Status->find('list');
		$andamentos = $this->Tecnologia->Andamento->find('list');
		$titulares = $this->Tecnologia->Titular->find('list');
		//$status_transferencia = $this->Tecnologia->StatusTransferencia->find('list');
		$status_transferencia = array('st_ofertada'=>'Ofertada','st_em_negociacao'=>'Em Negociação','st_licenciada'=>'Licenciada/Transferida','st_parceria'=>'Parceria','st_contrato_rescindido'=>'Contrato Rescindido','st_vitrine_tecnologica'=>'Vitrine Tecnológica');

		$param['order'] = array('Unidade.nome ASC');
		$unidades = $this->Tecnologia->Unidade->find('list',$param);

		$param['order'] = array('Departamento.nome ASC');
		$departamentos = $this->Tecnologia->Departamento->find('list',$param);

		// ANOS //
		$params = array(
			'fields'=>array('DISTINCT(YEAR(Tecnologia.data)) as ano'),
			'order' => array('Tecnologia.data ASC'),
			'recursive' => 0
		);
		
		$anosTmp = $this->Tecnologia->find('all', $params);
		$anos = array();
		
		for ($i=0; $i < count($anosTmp); $i++) {
			$anos[$anosTmp[$i][0]['ano']] = $anosTmp[$i][0]['ano'];
		}
		$desdes = $ates = $anos;

		$mesDes = array(
			1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro', 
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro'
        );

        $mesAtes = $mesDes;

        $colunas = $this->Tecnologia->CamposExportacao();
		

		$this->set(compact('redatores','areas','areas_conhecimento','titulares','status_transferencia','unidades','departamentos', 'status', 'inventores', 'desdes', 'ates','andamentos','populate_palavras_chave','mesDes','mesAtes','colunas'));
	}

	function exportar(){
		set_time_limit(300);
		$this->autoRender = false;

		$inventores_key = array_search('inventores', $_POST['fields']);
		if($inventores_key){
			$tem_inventores = true;
			unset($_POST['fields'][$inventores_key]);
		}

		$titulares_key = array_search('titulares', $_POST['fields']);
		if($titulares_key){
			$tem_titulares = true;
			unset($_POST['fields'][$titulares_key]);
		}

		$ultimo_despacho_key = array_search('ultimo_despacho', $_POST['fields']);
		if($ultimo_despacho_key){
			$tem_ultimo_despacho = true;
			unset($_POST['fields'][$ultimo_despacho_key]);
		}

		$tecnologias = $this->Tecnologia->find('all',array(
			'conditions' => array('Tecnologia.id' => $_POST['ids']),
			'fields' => $_POST['fields']
		));

		$colunas = $this->Tecnologia->CamposExportacao();

		//Cria a planilha
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		
		//Cria o cabeçalho
		for ($i=1; $i <= count($_POST['fields']) ; $i++) { 
			$sheet->getCellByColumnAndRow($i,1)->setValue($colunas[$_POST['fields'][$i-1]]['label']);
			$sheet->getStyle($sheet->getCellByColumnAndRow($i,1)->getCoordinate())->getFont()->setBold( true );	
			if(isset($colunas[$_POST['fields'][$i-1]]['width']))
				$sheet->getColumnDimensionByColumn($i)->setWidth($colunas[$_POST['fields'][$i-1]]['width']);
		}
		if(isset($tem_ultimo_despacho)){
			$cell = $sheet->getCellByColumnAndRow($i++,1);
			$cell->setValue("Último Despacho");
			$sheet->getStyle($cell->getCoordinate())->getFont()->setBold(true);	
			$sheet->getColumnDimensionByColumn($i-1)->setWidth(25);
		}
		if(isset($tem_inventores )){
			$cell = $sheet->getCellByColumnAndRow($i++,1);
			$cell->setValue("Inventores");
			$sheet->getStyle($cell->getCoordinate())->getFont()->setBold(true);	
			$sheet->getColumnDimensionByColumn($i-1)->setWidth(50);
		}
		if(isset($tem_titulares)){
			$cell = $sheet->getCellByColumnAndRow($i++,1);
			$cell->setValue("Titulares");
			$sheet->getStyle($cell->getCoordinate())->getFont()->setBold(true);	
			$sheet->getColumnDimensionByColumn($i-1)->setWidth(25);
		}

		$andamentos = $this->Tecnologia->Andamento->find('list');
		//$status_transferencia = $this->Tecnologia->StatusTransferencia->find('list');

		$andamentos[0] = $status_transferencia[0] = "";
		$andamentos[NULL] = $status_transferencia[NULL] = "";

		$lineNumber = 1;
		foreach ($tecnologias as $key => $tecnologia) {
			$lineNumber++;
			for ($i=1; $i <= count($_POST['fields']) ; $i++) {
				switch ($_POST['fields'][$i-1]) {
					case 'andamento_id':
						$cellValue = $andamentos[$tecnologia['Tecnologia'][$_POST['fields'][$i-1]]];
						break;
					//case 'status_transferencia_id':
					//	$cellValue = $status_transferencia[$tecnologia['Tecnologia'][$_POST['fields'][$i-1]]];
					//	break;
					default:
						$cellValue = $tecnologia['Tecnologia'][$_POST['fields'][$i-1]];
						break;
				}
				$sheet->getCellByColumnAndRow($i,$lineNumber)->setValue($cellValue);	
				$sheet->getStyle($sheet->getCellByColumnAndRow($i,$lineNumber)->getCoordinate())->getAlignment()->setWrapText(true);
				$sheet->getStyle($sheet->getCellByColumnAndRow($i,$lineNumber)->getCoordinate())->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
			}
			if(isset($tem_ultimo_despacho)){
				$count = count($tecnologia['Publicacao']);
				if($count > 0)
				{
					$sheet->getCellByColumnAndRow($i++,$lineNumber)->setValue('"'.$tecnologia['Publicacao'][0]['codigo_despacho'].'"');
				}
				else{
					$sheet->getCellByColumnAndRow($i++,$lineNumber)->setValue('');
				}
				$sheet->getStyle($sheet->getCellByColumnAndRow($i-1,$lineNumber)->getCoordinate())->getAlignment()->setWrapText(true);
				$sheet->getStyle($sheet->getCellByColumnAndRow($i-1,$lineNumber)->getCoordinate())->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
			}
			if(isset($tem_inventores)){
				$inventores = "";
				foreach ($tecnologia['Inventor'] as $key => $inventor) {
					if($key == 0){
						$inventores = $inventor['nome'];
					}else{
						$inventores = $inventores."\n".$inventor['nome'];
					}
				}
				$sheet->getCellByColumnAndRow($i++,$lineNumber)->setValue($inventores);
				$sheet->getStyle($sheet->getCellByColumnAndRow($i-1,$lineNumber)->getCoordinate())->getAlignment()->setWrapText(true);
				$sheet->getStyle($sheet->getCellByColumnAndRow($i-1,$lineNumber)->getCoordinate())->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
			}
			if(isset($tem_titulares)){
				$titulares = "";
				foreach ($tecnologia['Titular'] as $key => $titular) {
					if($key == 0){
						$titulares = $titular['nome'];
					}else{
						$titulares = $titulares."\n".$titular['nome'];
					}			
				}
				$sheet->getCellByColumnAndRow($i++,$lineNumber)->setValue($titulares);
				$sheet->getStyle($sheet->getCellByColumnAndRow($i-1,$lineNumber)->getCoordinate())->getAlignment()->setWrapText(true);
				$sheet->getStyle($sheet->getCellByColumnAndRow($i-1,$lineNumber)->getCoordinate())->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
			}
		}

		$writer = new Xlsx($spreadsheet);

		ob_start();
		$writer->save("php://output");
		$xlsData = ob_get_contents();
		ob_end_clean();

		$response =  array(
        	'op' => 'ok',
        	'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
    	);

		die(json_encode($response));		
	}


	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for tecnologia', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Tecnologia->delete($id, true)) {

			$query = sprintf("UPDATE tecnologias SET prioridade_interna_id = NULL WHERE prioridade_interna_id = %d", $id);
			$resultado = $this->Tecnologia->query($query);
			$this->Session->setFlash(__('Tecnologia deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Tecnologia was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function ajaxAdicionarArquivos($id = null) {
		// Reference general return: printf(json_encode(var_export($this->data, true)));exit;
		Configure::write('debug', 0);
		$this->autoRender = false;

		$tipo_documento_id = $this->data['tipo_documento_id'];

		if ( empty($this->data) /*|| empty($this->data['Tecnologia']['arquivo']['tmp_name'])*/ ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, 'Favor enviar um arquivo.');exit;
		}

		// initialize the upload object
		$this->Upload->upload( $this->data['Tecnologia']['arquivo'] );

		$uuid = String::uuid();
		$filename = $uuid;
		
		$nomeOriginal = $this->data['Tecnologia']['arquivo']['name'];
		$mimetype     = $this->data['Tecnologia']['arquivo']['type'];

		$this->Upload->file_new_name_body = $filename;
		$this->Upload->file_safe_name     = false;
		$this->Upload->file_auto_rename   = false;
		$this->Upload->file_overwrite     = true;
		$this->Upload->Process(PATH_ARQUIVOS); 

		if (!$this->Upload->processed) {
			$this->Upload->clean();
			printf('{"sucesso":%d, "retorno":"%s"}', 0, 'Não foi possível adicionar o arquivo: ' . $this->Upload->error );
			exit;
		}

		$saved_filename = $this->Upload->file_dst_name;

		// Clean the temp files generated by the upload class
		$this->Upload->clean();

		// Save to database
		$saving                             = array();
		$saving['Arquivo']['id']            = $filename;
		$saving['Arquivo']['nomedisco']     = $saved_filename;
		$saving['Arquivo']['nomeoriginal']  = $nomeOriginal;
		$saving['Arquivo']['tecnologia_id'] = $id;
		$saving['Arquivo']['tipo_documento_id'] = $tipo_documento_id;
		$saving['Arquivo']['mimetype']      = $mimetype;
		$this->Tecnologia->Arquivo->create();
		$this->Tecnologia->Arquivo->save($saving);

		$this->loadModel('Documento');
		$tipos_documentos = $this->Documento->find('list');

		printf('{"sucesso":%d, "nomeOriginal":"%s", "id":"%s", "tipoDocumento":"%s"}', 1, $nomeOriginal, $filename, $tipos_documentos[$tipo_documento_id]);exit;
	}
			
	function ajaxListarInventores() {
		Configure::write('debug', 0);
				
		$nome = $_GET['term'];
				
		$params = array(
			'fields'=>array('id','nome'),
			'order' => array('Inventor.nome ASC'),
			'conditions' => array('Inventor.nome LIKE' => $nome.'%'),
			'recursive' => 0
		);
		
		$inventores = $this->Tecnologia->Inventor->find('list', $params);
		$this->layout = '';
		$this->set('inventores', $inventores);		
	}//ajaxListarInventores
	
	function ajaxListarPalavraschave() {
		Configure::write('debug', 0);
				
		$nome = $_GET['term'];
				
		$params = array(
			'fields'=>array('id','palavra'),
			'order' => array('Palavrachave.palavra ASC'),
			'conditions' => array('Palavrachave.palavra LIKE' => '%' . $nome . '%'),
			'recursive' => 0
		);
		
		$palavras = $this->Tecnologia->Palavrachave->find('list', $params);
		$this->layout = '';
		$this->set('palavraschave', $palavras);		
	}//ajaxListarPalavraschave	
	
	function ajaxDesassociarInventor() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$inventor_id = $_GET['id'];
		$tecnologia_id = $_GET['tec_id'];
		
		$query = sprintf("DELETE FROM inventores_tecnologias WHERE tecnologia_id = %d AND inventor_id = %d LIMIT 1", $tecnologia_id, $inventor_id);
		$resultado = $this->Tecnologia->query($query);
		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Inventor desassociado com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao desassociar este inventor. Saia do sistema e tente novamente.", true) );
		}
		
	}//ajaxDesassociarInventor

	function ajaxDesassociarAreaConhecimento() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$area_conhecimento_id = $_GET['id'];
		$tecnologia_id = $_GET['tec_id'];
		
		$query = sprintf("DELETE FROM areas_conhecimento_tecnologias WHERE tecnologia_id = %d AND area_conhecimento_id = %d LIMIT 1", $tecnologia_id, $area_conhecimento_id);
		$resultado = $this->Tecnologia->query($query);
		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Área do conhecimento desassociada com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao desassociar esta área do conhecimento. Saia do sistema e tente novamente.", true) );
		}
		
	}//ajaxDesassociarAreaDoConhecimento



	function ajaxListarTitulares() {
		Configure::write('debug', 0);
				
		$nome = $_GET['term'];
				
		$params = array(
			'fields'=>array('id','nome'),
			'order' => array('Titular.nome ASC'),
			'conditions' => array('Titular.nome LIKE' => $nome.'%'),
			'recursive' => 0
		);
		
		$titulares = $this->Tecnologia->Titular->find('list', $params);
		$this->layout = '';
		$this->set('titulares', $titulares);		
	}//ajaxListarTitulares

	function ajaxAssociarTitular() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$titular_id = $_GET['id'];
		$tecnologia_id = $_GET['tec_id'];
		
		// checa para ver se este autor já não está associado a esta tecnologia antes
		$query = sprintf("
		SELECT * FROM tecnologias_titulares 
		WHERE titular_id=%d AND tecnologia_id=%d
		LIMIT 1", 
		$titular_id, $tecnologia_id );
		$resultado = $this->Tecnologia->query($query);

		if ( count($resultado) ) {
			// houve resultado na busca, indicando que tentou-se repetir uma associação
			// retorna um JSON com o erro
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __($query, true) );
			exit;
		}
		
		$query = sprintf("
		INSERT INTO tecnologias_titulares (
			tecnologia_id,
			titular_id
		) VALUES (%d, %d)", 
		$tecnologia_id, $titular_id );
		$resultado = $this->Tecnologia->query($query);

		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Titular associado com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __($query, true) );
		}
		
	}//ajaxAssociarTitular

	function ajaxDesassociarTitular() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$titular_id = $_GET['id'];
		$tecnologia_id = $_GET['tec_id'];
		
		$query = sprintf("DELETE FROM tecnologias_titulares WHERE tecnologia_id = %d AND titular_id = %d LIMIT 1", $tecnologia_id, $titular_id);
		$resultado = $this->Tecnologia->query($query);
		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Titular desassociado com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao desassociar este inventor. Saia do sistema e tente novamente.", true) );
		}
		
	}//ajaxDesassociarTitular

	function ajaxListarDepartamentos() {
		Configure::write('debug', 0);
				
		$nome = $_GET['term'];
				
		$params = array(
			'fields'=>array('id','nome','Unidade.id','Unidade.nome'),
			'order' => array('Departamento.nome ASC'),
			'conditions' => array(
								'OR'=>array(
										'Departamento.nome LIKE' => '%'.$nome.'%',
										'Unidade.nome LIKE' => '%'.$nome.'%',
								)
							),
			'recursive' => 0
		);
		
		$departamentos = $this->Tecnologia->Departamento->find('all', $params);
		$this->layout = '';
		$this->set('departamentos', $departamentos);	
	}//ajaxListarDepartamentos


	function ajaxAssociarDepartamento() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$departamento_id = $_GET['id'];
		$unidade_id = $_GET['uni_id'];
		$tecnologia_id = $_GET['tec_id'];
		
		// checa para ver se este autor já não está associado a esta tecnologia antes
		$query = sprintf("
		SELECT * FROM departamentos_tecnologias 
		WHERE departamento_id=%d AND tecnologia_id=%d
		LIMIT 1", 
		$departamento_id, $tecnologia_id );
		$resultado = $this->Tecnologia->query($query);

		if ( count($resultado) ) {
			// houve resultado na busca, indicando que tentou-se repetir uma associação
			// retorna um JSON com o erro
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __($query, true) );
			exit;
		}
		
		$query = sprintf("
		INSERT INTO departamentos_tecnologias (
			tecnologia_id,
			departamento_id,
			unidade_id
		) VALUES (%d, %d, %d)", 
		$tecnologia_id, $departamento_id, $unidade_id);
		$resultado = $this->Tecnologia->query($query);

		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Origem associada com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __($query, true) );
		}
		
	}//ajaxAssociarTitular

	function ajaxDesassociarDepartamento() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$departamento_id = $_GET['id'];
		$tecnologia_id = $_GET['tec_id'];
		
		$query = sprintf("DELETE FROM departamentos_tecnologias WHERE tecnologia_id = %d AND departamento_id = %d LIMIT 1", $tecnologia_id, $departamento_id);
		$resultado = $this->Tecnologia->query($query);
		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Departamento desassociado com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao desassociar este departamento. Saia do sistema e tente novamente.", true) );
		}
		
	}//ajaxDesassociarDepartamento
	
	function ajaxAssociarInventor() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$inventor_id = $_GET['id'];
		$tecnologia_id = $_GET['tec_id'];
		
		// checa para ver se este autor já não está associado a esta tecnologia antes
		$query = sprintf("
		SELECT * FROM inventores_tecnologias 
		WHERE inventor_id=%d AND tecnologia_id=%d
		LIMIT 1", 
		$inventor_id, $tecnologia_id );
		$resultado = $this->Tecnologia->query($query);
		
		if ( count($resultado) ) {
			// houve resultado na busca, indicando que tentou-se repetir uma associação
			// retorna um JSON com o erro
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Este inventor já está associado com esta tecnologia.", true) );
			exit;
		}
		
		$query = sprintf("
		INSERT INTO inventores_tecnologias (inventor_id,tecnologia_id) VALUES (%d, %d)", $inventor_id, $tecnologia_id );
		$resultado = $this->Tecnologia->query($query);
		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Inventor associado com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao associar este inventor. Saia do sistema e tente novamente.", true) );
		}
		
	}//ajaxAssociarInventor

	function ajaxAssociarAreaConhecimento() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$area_conhecimento_id = $_GET['id'];
		$tecnologia_id = $_GET['tec_id'];
		
		// checa para ver se este autor já não está associado a esta tecnologia antes
		$query = sprintf("
		SELECT * FROM areas_conhecimento_tecnologias 
		WHERE area_conhecimento_id=%d AND tecnologia_id=%d
		LIMIT 1", 
		$area_conhecimento_id, $tecnologia_id );
		$resultado = $this->Tecnologia->query($query);
		
		if ( count($resultado) ) {
			// houve resultado na busca, indicando que tentou-se repetir uma associação
			// retorna um JSON com o erro
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Este inventor já está associado com esta tecnologia.", true) );
			exit;
		}
		
		$query = sprintf("
		INSERT INTO areas_conhecimento_tecnologias (area_conhecimento_id,tecnologia_id) VALUES (%d, %d)", $area_conhecimento_id, $tecnologia_id );
		$resultado = $this->Tecnologia->query($query);
		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Área do conhecimento associado com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao associar esta área do conhecimento. Saia do sistema e tente novamente.", true) );
		}
		
	}//ajaxAssociarAreaConhecimento
	
	function ajaxAssociarPalavrachave() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$palavrachave_id = $_GET['id'];
		$tecnologia_id   = $_GET['tec_id'];
		
		// checa para ver se esta palavra-chave e tecnologia já não estão associados
		$query = sprintf("
		SELECT * FROM palavraschave_tecnologias 
		WHERE palavrachave_id=%d AND tecnologia_id=%d
		LIMIT 1", 
		$palavrachave_id, $tecnologia_id );
		$resultado = $this->Tecnologia->query($query);
		
		if ( count($resultado) ) {
			// houve resultado na busca, indicando que tentou-se repetir uma associação
			// retorna um JSON com o erro
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Esta palavra-chave já está associada com esta tecnologia", true) );
			exit;
	}
		
		$query = sprintf("
		INSERT INTO palavraschave_tecnologias (
			palavrachave_id,
			tecnologia_id
		) VALUES (%d, %d)", 
		$palavrachave_id, $tecnologia_id );
		$resultado = $this->Tecnologia->query($query);
		
		// Não utilizei o sistema abaixo pois o cake apagava o restante das associações, a não ser q eu buscasse antes os outros inventores e gerasse o array com eles
		// gera array de associação
		// $data = array();
		// $data['Tecnologia'] = array('id' => $tecnologia_id);
		// $data['Inventor'] = array('Inventor' => $inventor_id);
		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Palavra-chave associada com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao associar esta palavra-chave. Saia do sistema e tente novamente.", true) );
		}
		
	}//ajaxAssociarPalavrachave
	
	function ajaxDesassociarPalavrachave() {		
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$palavrachave_id = $_GET['id'];
		$tecnologia_id = $_GET['tec_id'];
		
		$query = sprintf("DELETE FROM palavraschave_tecnologias WHERE tecnologia_id = %d AND palavrachave_id = %d LIMIT 1", $tecnologia_id, $palavrachave_id);
		$resultado = $this->Tecnologia->query($query);
		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Palavra-chave desassociada com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao desassociar esta palavra-chave. Saia do sistema e tente novamente.", true) );
		}
		
	}//ajaxDesassociarPalavrachave

	function relatorio() {
		$this->Tecnologia->recursive = 1;
		$tecnologias = $this->paginate();
		// debug($tecnologias);
		$this->set('tecnologias', $tecnologias);
		
		$areas = $this->Tecnologia->Area->find('list');
		//$status = $this->Tecnologia->Status->find('list');
		$andamentos = $this->Tecnologia->Andamento->find('list');
		$inventores = $this->Tecnologia->Inventor->find('list');
				
		$this->set(compact('areas', 'status', 'inventores'));
	}
		
		
	// FUNCAO DE TESTES
	function ajaxPedidos() {
		$this->layout = '';
		$this->autoRender = false;
		$this->Tecnologia->recursive = -1;

		$query = $_GET['q'];
		
		$pedidos = $this->Tecnologia->find('all',array('conditions' => array('Tecnologia.num_pedido LIKE' => '%'.$query.'%'),
														'fields' => array('Tecnologia.id', 'Tecnologia.titulo AS name', 'Tecnologia.num_pedido'),
														'limit'=>10
														)
										);
		
		$resultado = array();

		foreach ($pedidos as $pedido) {
			array_push($resultado, $pedido['Tecnologia']);
		}

		return json_encode($resultado);
	}

	function ajaxCertificados() {
		$this->layout = '';
		$this->autoRender = false;
		$this->Tecnologia->recursive = -1;

		$query = $_GET['q'];
		
		$pedidos = $this->Tecnologia->find('all',array('conditions' => array('Tecnologia.num_pedido LIKE' => '%'.$query.'%', 'Tecnologia.natureza_id'=>3),
														'fields' => array('Tecnologia.id', 'Tecnologia.titulo AS name', 'Tecnologia.num_pedido'),
														'limit'=>10
												)
										);
		
		$resultado = array();

		foreach ($pedidos as $pedido) {
			array_push($resultado, $pedido['Tecnologia']);
		}

		return json_encode($resultado);
	}


}
?>
