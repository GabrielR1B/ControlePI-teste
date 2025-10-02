<?php
require 'vendors/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PatentesInternacionaisController extends AppController {

	var $name = 'PatentesInternacionais';
	var $uses = array('PatenteInternacional');
	var $components = array('DateParse','Upload');
	//var $components = array('Upload');
	var $helpers = array('Html'); 

	var $paginate = array(
        'limit' => 25,
        'order' => array(
            'PatenteInternacional.data' => 'desc'
        )
    );

	
	function index() {

		$patentes = $this->PatenteInternacional->recursive = 1;
		$patentes = $this->paginate('PatenteInternacional');
			
		$this->set(compact('patentes'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Tecnologia inválida', true));
			$this->redirect(array('action' => 'index'));
		}else{
			if(!$this->PatenteInternacional->findById($id)){
				$this->Session->setFlash(__('Tecnologia inválida', true));
				$this->redirect(array('action' => 'index'));
			}
		}
		$this->PatenteInternacional->recursive = 1;

		$patente = $this->PatenteInternacional->read(null, $id);

		//Obtém todas as patentes nacionais vinculadas à patente internacional
		$nacionais = $this->PatenteInternacional->query(sprintf('SELECT * FROM patentes_internacionais_tecnologias JOIN tecnologias ON tecnologia_id = tecnologias.id WHERE patente_internacional_id = %d',$id));
		$nacionais = Set::combine($nacionais, '{n}.tecnologias.id', '{n}.tecnologias');
		$nacionais_id = Set::combine($nacionais, '{n}.id', '{n}.id');

		//Se tem patentes nacionais relacionadas, obtém todas as internacionais, inventores, origens e titulares dessas relacionadas a essas patentes nacionais
		$nacionais_ids_query = '('.implode(',', $nacionais_id) .')';
		$ids = $internacionais = $inventores = $origens = $titulares = array();
		if(!empty($nacionais_id)){
				$internacionais_ids = $this->PatenteInternacional->query('SELECT patente_internacional_id FROM patentes_internacionais_tecnologias WHERE tecnologia_id IN '.$nacionais_ids_query. 'AND patente_internacional_id != '.$id);

				//$ids = array();
				foreach ($internacionais_ids as $internacional_id) {
					array_push($ids,$internacional_id['patentes_internacionais_tecnologias']['patente_internacional_id']);
				}

				$internacionais = Set::combine( $this->PatenteInternacional->find('all',array('conditions'=>array('PatenteInternacional.id'=>$ids))), '{n}.patentes_internacionais.id', '{n}');
				$inventores = Set::combine($this->PatenteInternacional->query('SELECT inventores.id,inventores.nome FROM inventores_tecnologias JOIN inventores ON inventor_id = inventores.id WHERE tecnologia_id in ' . $nacionais_ids_query . 'group by inventores.nome'), '{n}.inventores.id', '{n}');
				$origens = Set::combine($this->PatenteInternacional->query('SELECT departamentos.id,departamentos.nome, departamentos.unidade_id FROM departamentos_tecnologias JOIN departamentos ON departamento_id = departamentos.id WHERE tecnologia_id in ' . $nacionais_ids_query . 'group by departamentos.nome'), '{n}.departamentos.id', '{n}');
				$titulares = Set::combine($this->PatenteInternacional->query('SELECT titulares.id, titulares.nome FROM tecnologias_titulares JOIN titulares ON titular_id = titulares.id WHERE tecnologia_id in ' . $nacionais_ids_query . 'group by titulares.nome'), '{n}.titulares.id', '{n}');
		}

		foreach ($patente['Titular'] as $titular) {
			if(!array_key_exists($titular['id'], $titulares)){
				array_push($titulares, array('titulares'=>array('id'=>$titular['id'],'nome'=>$titular['nome'])));
			}		
		}

		foreach ($patente['Inventor'] as $inventor) {
			if(!array_key_exists($inventor['id'], $patente['Inventor'])){
				array_push($inventores, array('inventores'=>array('id'=>$inventor['id'],'nome'=>$inventor['nome'])));
			}
		}

		foreach ($patente['Departamento'] as $departamento) {
			if(!array_key_exists($departamento['id'], $origens)){
				array_push($origens, array('departamentos'=>array('id'=>$departamento['id'],'nome'=>$departamento['nome'],'unidade_id'=>$departamento['unidade_id'])));
			}
		}

		//Internacionais relacionadas pelo número da pasta
		//$internacionais_mesma_pasta = $this->PatenteInternacional->find('all',array('conditions'=>array('PatenteInternacional.id !='=>$id, 'PatenteInternacional.id NOT'=>$ids, 'PatenteInternacional.pasta'=>$patente['PatenteInternacional']['pasta'])));
		if($ids){
			$internacionais_mesma_pasta = $this->PatenteInternacional->query(sprintf("SELECT * FROM patentes_internacionais AS PatenteInternacional WHERE pasta = %d AND id != %d AND id NOT IN (%s);", $patente['PatenteInternacional']['pasta'], $patente['PatenteInternacional']['id'],implode(',',$ids)));
		}else{
			$internacionais_mesma_pasta = $this->PatenteInternacional->query(sprintf("SELECT * FROM patentes_internacionais AS PatenteInternacional WHERE pasta = %d AND id != %d;", $patente['PatenteInternacional']['pasta'], $patente['PatenteInternacional']['id']));
		}
		$internacionais = array_merge($internacionais, $internacionais_mesma_pasta);

		//$internacionais = $this->PatenteInternacional->find('all',array('conditions'=>array('PatenteInternacional.id'=>$ids)));

		$this->PatenteInternacional->Pais->recursive = -1;
		$paises = $this->PatenteInternacional->Pais->find('all');
		$paises = Set::combine($paises, '{n}.Pais.id', '{n}.Pais');
		$unidades = $this->PatenteInternacional->Departamento->Unidade->find('list');

		$this->set(compact('paises','patente','nacionais','internacionais','inventores','unidades','origens','titulares'));
		$this->set('escritorios', $this->PatenteInternacional->Escritorio->find('list'));
		$this->set('naturezas_internacionais', $this->PatenteInternacional->NaturezaPatenteInternacional->find('list'));
		$this->set('naturezas_nacionais', $this->PatenteInternacional->Tecnologia->NaturezaTecnologia->find('list'));
		$this->set('empresas',$patente['Empresa']);
	}


	function add() {
		if (!empty($this->data)) {
			//print_r($this->data);
			//exit();

			if($this->data['PatenteInternacional']['natureza_id'] == '1' or 
			   $this->data['PatenteInternacional']['natureza_id'] == '3' or 
			   $this->data['PatenteInternacional']['natureza_id'] == '4'){

				$ids_tecnologias = explode(',', $this->data['PatenteInternacional']['tecnologia_id']);
				$this->data['Tecnologia']['Tecnologia'] = array();

				foreach ($ids_tecnologias as $id) {
					array_push($this->data['Tecnologia']['Tecnologia'], $id);
				}
			}

			if($this->data['PatenteInternacional']['natureza_id'] == '2'){	

				//$pct = $this->PatenteInternacional->findById($this->data['PatenteInternacional']['pct_id']);
				//$this->data['PatenteInternacional']['pasta'] = $pct['PatenteInternacional']['pasta'];

				$this->data['Tecnologia']['Tecnologia'] = array();
				foreach ($pct['Tecnologia'] as $tecnologia) {
					array_push($this->data['Tecnologia']['Tecnologia'], $tecnologia['id']);
				}
			}

			if($this->PatenteInternacional->save($this->data)) {
				$this->Session->setFlash(__('The tecnologia has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tecnologia could not be saved. Please, try again.', true));
			}
		}
		
		$naturezas = $this->PatenteInternacional->NaturezaPatenteInternacional->find('list'); 
		$areas = $this->PatenteInternacional->Area->find('list'); 
		$redatores = $this->PatenteInternacional->Redator->find('list');
		$status = $this->PatenteInternacional->StatusInternacional->find('list');
		$status_transferencias = $this->PatenteInternacional->StatusTransferencia->find('list');
		$paises = $this->PatenteInternacional->Pais->find('list', array('conditions'=> array('Pais.id !='=>'1'), 'order'=>'Pais.nome'));
		$escritorios = $this->PatenteInternacional->Escritorio->find('list',array('order'=>'Escritorio.nome'));

		$this->set(compact('status','status_transferencias','naturezas','areas','paises','escritorios','redatores'));
	}

	function edit($id = null) {
		if (empty($this->data)) {
			$this->data = $this->PatenteInternacional->read(null, $id);
			$naturezas = $this->PatenteInternacional->NaturezaPatenteInternacional->find('list');
			$areas = $this->PatenteInternacional->Area->find('list'); 
			$status = $this->PatenteInternacional->StatusInternacional->find('list');
			$status_transferencias = $this->PatenteInternacional->StatusTransferencia->find('list');
			$paises = $this->PatenteInternacional->Pais->find('list', array('conditions'=> array('Pais.id !='=>'1'), 'order'=>'Pais.nome'));
			$escritorios = $this->PatenteInternacional->Escritorio->find('list',array('order'=>'Escritorio.nome'));
			$titulares = $this->data['Titular'];
			$departamentos = $this->data['Departamento'];
			$inventores = $this->data['Inventor'];
			$empresas = $this->data['Empresa'];
			$arquivos = $this->data['Arquivo'];

			$nacionais_ids = $this->PatenteInternacional->query('SELECT tecnologia_id FROM patentes_internacionais_tecnologias WHERE patente_internacional_id = '.$id);
			$ids = array();

			foreach ($nacionais_ids as $nacional_id) {
				array_push($ids, $nacional_id['patentes_internacionais_tecnologias']['tecnologia_id']);
			}

			$this->PatenteInternacional->Tecnologia->recursive = 0;
			$tecnologias = $this->PatenteInternacional->Tecnologia->find('all',array('conditions'=>array('Tecnologia.id'=>$ids)));

			$populate_tecnologias = array();
			foreach ($tecnologias as $tecnologia) {
				array_push($populate_tecnologias, array('id'=>(string)$tecnologia['Tecnologia']['id'],
														   'num_pedido' => $tecnologia['Tecnologia']['num_pedido'],
														)
				);
			}

			$unidades = $this->PatenteInternacional->Departamento->Unidade->find('list');
			$redatores = $this->PatenteInternacional->Redator->find('list');

			$patente_internacional_id = $id;
			$count_nacionais = count($tecnologias);
			$this->set(compact('arquivos','count_nacionais','inventores','empresas','titulares','unidades','departamentos','status','naturezas','areas','status_transferencias','paises','escritorios','populate_tecnologias','patente_internacional_id','redatores'));
		}else{
			$this->data['PatenteInternacional']['tecnologia_id'] = explode(',', $this->data['PatenteInternacional']['tecnologia_id']);

			if ($this->PatenteInternacional->save($this->data)) {
				$this->PatenteInternacional->query("DELETE FROM patentes_internacionais_tecnologias WHERE patente_internacional_id = ".$id);
				foreach ($this->data['PatenteInternacional']['tecnologia_id'] as $tecnologia_id) {
					$this->PatenteInternacional->query(sprintf("INSERT INTO patentes_internacionais_tecnologias VALUES (NULL, %d, %d)",$id,$tecnologia_id));
					//echo "Teste";
				}

				$this->Session->setFlash(__('The tecnologia has been saved', true));
				$this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(__('The tecnologia could not be saved. Please, try again.', true));
			}
		}
	}

	function search() {
			$paises = $this->PatenteInternacional->Pais->find('list',array('order'=>array('Pais.nome')));
			$inventores = $this->PatenteInternacional->Inventor->find('list',array('order'=>array('Inventor.nome')));
			$titulares = $this->PatenteInternacional->Titular->find('list',array('order'=>array('Titular.nome')));
			$unidades = $this->PatenteInternacional->Unidade->find('list',array('order'=>array('Unidade.nome')));
			$departamentos = $this->PatenteInternacional->Tecnologia->Departamento->find('list',array('order'=>array('Departamento.nome')));
			$status = $this->PatenteInternacional->StatusInternacional->find('list');
			$naturezas = $this->PatenteInternacional->NaturezaPatenteInternacional->find('list');

			// ANOS //
			$params = array(
				'fields'=>array('MIN(YEAR(PatenteInternacional.data_internacional)) as minAno','MAX(YEAR(PatenteInternacional.data_internacional)) as maxAno'),
				'order' => array('PatenteInternacional.data ASC'),
				'recursive' => 0
			);
			$anosTmp = $this->PatenteInternacional->find('all', $params);
			$minAno = $anosTmp[0][0]['minAno'];
			$maxAno = $anosTmp[0][0]['maxAno'];

			$anos = array();
			for ($minAno; $minAno <= $maxAno ; $minAno++) { 
				array_push($anos, $minAno);
			}

			$colunas = $this->PatenteInternacional->CamposExportacao();

			$desdes = $ates = $anos;
			$this->set(compact('naturezas','paises','inventores','titulares','unidades','departamentos','status','desdes','ates','colunas'));


		$patentes_internacionais =  array();
		if (!empty($this->data)) {
			$condicoes = array(); // armazena as condicoes da busca

			$realizarBusca = 0;
			if($this->data['PatenteInternacional']['titulo'])
			{
				$realizarBusca++;
				$condicoes['PatenteInternacional.titulo LIKE'] = '%'.$this->data['PatenteInternacional']['titulo'].'%';
			}

			if($this->data['PatenteInternacional']['num_pedido'])
			{
				$realizarBusca++;
				$condicoes['PatenteInternacional.num_pedido LIKE'] = '%'.$this->data['PatenteInternacional']['num_pedido'].'%';
			}

			if($this->data['PatenteInternacional']['num_publicacao'])
			{
				$realizarBusca++;
				$condicoes['PatenteInternacional.num_publicacao LIKE'] = '%'.$this->data['PatenteInternacional']['num_publicacao'].'%';
				$condicoes['PatenteInternacional.natureza_id LIKE'] = 1;
			}

			if($this->data['PatenteInternacional']['pasta'])
			{
				$realizarBusca++;
				$condicoes['PatenteInternacional.pasta LIKE'] = '%'.$this->data['PatenteInternacional']['pasta'].'%';
			}

			if($this->data['PatenteInternacional']['pasta_juridico'])
			{
				$realizarBusca++;
				$condicoes['PatenteInternacional.pasta_juridico LIKE'] = '%'.$this->data['PatenteInternacional']['pasta_juridico'].'%';
			}

			if($this->data['PatenteInternacional']['num_processo_sei'])
			{
				$realizarBusca++;
				$condicoes['PatenteInternacional.num_processo_sei LIKE'] = '%'.$this->data['PatenteInternacional']['num_processo_sei'].'%';
			}

			if($this->data['PatenteInternacional']['natureza_id'])
			{
				$realizarBusca++;
				$condicoes['PatenteInternacional.natureza_id ='] = $this->data['PatenteInternacional']['natureza_id'];
			}

			if($this->data['PatenteInternacional']['pais_id'])
			{
				$realizarBusca++;
				$condicoes['PatenteInternacional.pais_id LIKE'] = '%'.$this->data['PatenteInternacional']['pais_id'].'%';
			}

			if($this->data['PatenteInternacional']['status_id'])
			{
				$realizarBusca++;
				$condicoes['PatenteInternacional.status_id'] = $this->data['PatenteInternacional']['status_id'];
			}

			if($this->data['PatenteInternacional']['desde_id'])
			{
				$realizarBusca++;
				$condicoes['YEAR(PatenteInternacional.data_internacional) >='] = $anos[$this->data['PatenteInternacional']['desde_id']];
			}

			if($this->data['PatenteInternacional']['ate_id'])
			{
				$realizarBusca++;
				$condicoes['YEAR(PatenteInternacional.data_internacional) <='] = $anos[$this->data['PatenteInternacional']['ate_id']];
			}



			$patentes_ids = array();
			if($realizarBusca > 0)
			{
				//A busca é realizada
				$options['conditions'] = $condicoes;
				$patentes = $this->PatenteInternacional->find('all', $options );
				if(empty($patentes)){
					return $patentes;
				}else{
					foreach ($patentes as $patente) {
						array_push($patentes_ids, $patente['PatenteInternacional']['id']);
					}
				}
			}	

			if($this->data['PatenteInternacional']['inventor_id'])
			{
				$inventor = $this->PatenteInternacional->Inventor->findById($this->data['PatenteInternacional']['inventor_id']);
				if(!isset($inventor['PatenteInternacional']))
				{
					$inventor['PatenteInternacional'] = array();
				}

				$ids_tecnologias_inventor = $this->PatenteInternacional->query("SELECT tecnologia_id FROM inventores_tecnologias WHERE inventor_id = ".$this->data['PatenteInternacional']['inventor_id']);
				$array_ids_tecnologias = array();
				foreach ($ids_tecnologias_inventor as $id) {
					array_push($array_ids_tecnologias, $id['inventores_tecnologias']['tecnologia_id']);
				}
				$tecnologiasInventor = $this->PatenteInternacional->Tecnologia->find('all',array('conditions'=>array('Tecnologia.id'=>$array_ids_tecnologias)));
				foreach ($tecnologiasInventor as $tecnologia) {
					foreach ($tecnologia['PatenteInternacional'] as $patenteInternacional) {
						array_push($inventor['PatenteInternacional'], $patenteInternacional);
					}
				}

				$resultado_inventor_ids = array();
				foreach ($inventor['PatenteInternacional'] as $patente) {
					array_push($resultado_inventor_ids, $patente['id']);
				}

				if($realizarBusca>0){
					$patentes_ids = array_intersect($patentes_ids, $resultado_inventor_ids);
				}else{
					$patentes_ids = $resultado_inventor_ids;
				}
				if(empty($patentes_ids)){
					return array();
				}
			}

			if($this->data['PatenteInternacional']['departamento_id'])
			{
				$departamento = $this->PatenteInternacional->Departamento->findById($this->data['PatenteInternacional']['departamento_id']);
				if(!isset($departamento['PatenteInternacional']))
				{
					$departamento['PatenteInternacional'] = array();
				}

				$ids_tecnologias_departamento = $this->PatenteInternacional->query("SELECT tecnologia_id FROM departamentos_tecnologias WHERE departamento_id = ".$this->data['PatenteInternacional']['departamento_id']);
				$array_ids_tecnologias = array();
				foreach ($ids_tecnologias_departamento as $id) {
					array_push($array_ids_tecnologias, $id['departamentos_tecnologias']['tecnologia_id']);
				}
				$tecnologiasDepartamento = $this->PatenteInternacional->Tecnologia->find('all',array('conditions'=>array('Tecnologia.id'=>$array_ids_tecnologias)));
				foreach ($tecnologiasDepartamento as $tecnologia) {
					foreach ($tecnologia['PatenteInternacional'] as $patenteInternacional) {
						array_push($departamento['PatenteInternacional'], $patenteInternacional);
					}
				}

				$resultado_departamento_ids = array();
				foreach ($departamento['PatenteInternacional'] as $patente) {
						array_push($resultado_departamento_ids, $patente['id']);
				}

				if($realizarBusca>0 || $this->data['PatenteInternacional']['inventor_id']){
					$patentes_ids = array_intersect($patentes_ids, $resultado_departamento_ids);
				}else{
					$patentes_ids = $resultado_departamento_ids;
				}
				if(empty($patentes_ids)){
					return array();
				}
			}

			if($this->data['PatenteInternacional']['unidade_id'])
			{
				$unidade = $this->PatenteInternacional->Unidade->findById($this->data['PatenteInternacional']['unidade_id']);
				if(!isset($unidade['PatenteInternacional']))
				{
					$unidade['PatenteInternacional'] = array();
				}	

				$ids_tecnologias_unidade = $this->PatenteInternacional->query("SELECT tecnologia_id FROM departamentos_tecnologias WHERE unidade_id = ".$this->data['PatenteInternacional']['unidade_id']);
				$array_ids_tecnologias = array();
				foreach ($ids_tecnologias_unidade as $id) {
					array_push($array_ids_tecnologias, $id['departamentos_tecnologias']['tecnologia_id']);
				}
				$tecnologiasUnidade = $this->PatenteInternacional->Tecnologia->find('all',array('conditions'=>array('Tecnologia.id'=>$array_ids_tecnologias)));
				foreach ($tecnologiasUnidade as $tecnologia) {
					foreach ($tecnologia['PatenteInternacional'] as $patenteInternacional) {
						array_push($unidade['PatenteInternacional'], $patenteInternacional);
					}
				}

				$resultado_unidade_ids = array();
				foreach ($unidade['PatenteInternacional'] as $patente) {
						array_push($resultado_unidade_ids, $patente['id']);
				}

				if($realizarBusca>0 || $this->data['PatenteInternacional']['inventor_id'] || $this->data['PatenteInternacional']['departamento_id']){
					$patentes_ids = array_intersect($patentes_ids, $resultado_unidade_ids);
				}else{
					$patentes_ids = $resultado_unidade_ids;
				}
				if(empty($patentes_ids)){
					return array();
				}
			}

			if($this->data['PatenteInternacional']['titular_id'])
			{
				$titular = $this->PatenteInternacional->Titular->findById($this->data['PatenteInternacional']['titular_id']);
				if(!isset($titular['PatenteInternacional']))
				{
					$titular['PatenteInternacional'] = array();
				}	

				$ids_tecnologias_titular = $this->PatenteInternacional->query("SELECT tecnologia_id FROM tecnologias_titulares WHERE titular_id = ".$this->data['PatenteInternacional']['titular_id']);
				$array_ids_tecnologias = array();
				foreach ($ids_tecnologias_titular as $id) {
					array_push($array_ids_tecnologias, $id['tecnologias_titulares']['tecnologia_id']);
				}
				$tecnologiasUnidade = $this->PatenteInternacional->Tecnologia->find('all',array('conditions'=>array('Tecnologia.id'=>$array_ids_tecnologias)));
				foreach ($tecnologiasUnidade as $tecnologia) {
					foreach ($tecnologia['PatenteInternacional'] as $patenteInternacional) {
						array_push($titular['PatenteInternacional'], $patenteInternacional);
					}
				}

				$resultado_titular_ids = array();
				foreach ($titular['PatenteInternacional'] as $patente) {
						array_push($resultado_titular_ids, $patente['id']);
				}

				if($realizarBusca>0 || $this->data['PatenteInternacional']['inventor_id'] || $this->data['PatenteInternacional']['departamento_id'] || $this->data['PatenteInternacional']['unidade_id']){
					$patentes_ids = array_intersect($patentes_ids, $resultado_titular_ids);
				}else{
					$patentes_ids = $resultado_titular_ids;
				}
				if(empty($patentes_ids)){
					return array();
				}
			}

			$patentes = $this->PatenteInternacional->find('all',array('conditions'=>array('PatenteInternacional.id'=>$patentes_ids),'order'=>array('PatenteInternacional.data'=>'DESC')));
		}		

		if(isset($patentes))
		{
			$ids = Set::extract($patentes, "{n}.PatenteInternacional.id");
		}else{
			$ids = array();
		}		
		$this->set('ids',json_encode($ids));

		$this->set(compact('patentes'));
	}

	function exportar(){
		set_time_limit(300);
		$this->autoRender = false;

		//$inventores_key = array_search('inventores', $_POST['fields']);
		//if($inventores_key){
		//	$tem_inventores = true;
		//	unset($_POST['fields'][$inventores_key]);
		//}
		//
		//$titulares_key = array_search('titulares', $_POST['fields']);
		//if($titulares_key){
		//	$tem_titulares = true;
		//	unset($_POST['fields'][$titulares_key]);
		//}

		$patentes = $this->PatenteInternacional->find('all',array(
			'conditions' => array('PatenteInternacional.id' => $_POST['ids']),
			'fields' => $_POST['fields']
		));

		$colunas = $this->PatenteInternacional->CamposExportacao();

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
		//if(isset($tem_inventores )){
		//	$cell = $sheet->getCellByColumnAndRow($i++,1);
		//	$cell->setValue("Inventores");
		//	$sheet->getStyle($cell->getCoordinate())->getFont()->setBold(true);	
		//	$sheet->getColumnDimensionByColumn($i-1)->setWidth(50);
		//}
		//if(isset($tem_titulares)){
		//	$cell = $sheet->getCellByColumnAndRow($i++,1);
		//	$cell->setValue("Titulares");
		//	$sheet->getStyle($cell->getCoordinate())->getFont()->setBold(true);	
		//	$sheet->getColumnDimensionByColumn($i-1)->setWidth(25);
		//}

		//$andamentos = $this->Tecnologia->Andamento->find('list');
		$status_transferencia = $this->PatenteInternacional->StatusTransferencia->find('list');
		$paises = $this->PatenteInternacional->Pais->find('list');

		//$andamentos[0] = $status_transferencia[0] = "";
		//$andamentos[NULL] = $status_transferencia[NULL] = "";

		$lineNumber = 1;
		foreach ($patentes as $key => $patente) {
			$lineNumber++;
			for ($i=1; $i <= count($_POST['fields']) ; $i++) {
				switch ($_POST['fields'][$i-1]) {
					case 'andamento_id':
						$cellValue = $andamentos[$patentes['PatenteInternacional'][$_POST['fields'][$i-1]]];
						break;
					case 'status_transferencia_id':
						$cellValue = $status_transferencia[$patente['PatenteInternacional'][$_POST['fields'][$i-1]]];
						break;
					case 'pais_id':
						if($patente['PatenteInternacional'][$_POST['fields'][$i-1]]){
							$cellValue = $paises[$patente['PatenteInternacional'][$_POST['fields'][$i-1]]];
						}else{
							$cellValue = '';
						}
						break;
					default:
						$cellValue = $patente['PatenteInternacional'][$_POST['fields'][$i-1]];
						break;
				}
				$sheet->getCellByColumnAndRow($i,$lineNumber)->setValue($cellValue);	
				$sheet->getStyle($sheet->getCellByColumnAndRow($i,$lineNumber)->getCoordinate())->getAlignment()->setWrapText(true);
				$sheet->getStyle($sheet->getCellByColumnAndRow($i,$lineNumber)->getCoordinate())->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
			}
			//if(isset($tem_inventores)){
			//	$inventores = "";
			//	foreach ($tecnologia['Inventor'] as $key => $inventor) {
			//		if($key == 0){
			//			$inventores = $inventor['nome'];
			//		}else{
			//			$inventores = $inventores."\n".$inventor['nome'];
			//		}
			//	}
			//	$sheet->getCellByColumnAndRow($i++,$lineNumber)->setValue($inventores);
			//	$sheet->getStyle($sheet->getCellByColumnAndRow($i-1,$lineNumber)->getCoordinate())->getAlignment()->setWrapText(true);
			//	$sheet->getStyle($sheet->getCellByColumnAndRow($i-1,$lineNumber)->getCoordinate())->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
			//}
			//if(isset($tem_titulares)){
			//	$titulares = "";
			//	foreach ($tecnologia['Titular'] as $key => $titular) {
			//		if($key == 0){
			//			$titulares = $titular['nome'];
			//		}else{
			//			$titulares = $titulares."\n".$titular['nome'];
			//		}			
			//	}
			//	$sheet->getCellByColumnAndRow($i++,$lineNumber)->setValue($titulares);
			//	$sheet->getStyle($sheet->getCellByColumnAndRow($i-1,$lineNumber)->getCoordinate())->getAlignment()->setWrapText(true);
			//	$sheet->getStyle($sheet->getCellByColumnAndRow($i-1,$lineNumber)->getCoordinate())->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
			//}
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

	function searchOld() {		
		// se houve uma busca
		if (!empty($this->data)) {
			//debug($this->data);
			$this->Tecnologia->recursive = 0;

			$condicoes = array(); // armazena as condicoes da busca
			$options   = array(); // será passada para a funcao 
		
			$titulo      = $this->data['PatenteInternacional']['titulo'];
			$num_pedido  = $this->data['PatenteInternacional']['num_pedido'];
			$pasta       = $this->data['PatenteInternacional']['pasta'];
			$status_id   = $this->data['PatenteInternacional']['status_id'];
			$anoDe       = $this->data['PatenteInternacional']['desde'];
			$anoAte      = $this->data['PatenteInternacional']['ate'];
		
			if (!empty($titulo)) {
				$condicoes['PatenteInternacional.titulo LIKE'] = '%'.$titulo.'%';
			}
		
			if (!empty($num_pedido)) {
				$condicoes['OR']['PatenteInternacional.num_pedido LIKE'] = '%'.$num_pedido.'%';
				$condicoes['OR']['PatenteInternacional.num_pct LIKE'] = '%'.$num_pedido.'%';
			}
			
			if (!empty($pasta)) {
				$condicoes['PatenteInternacional.pasta LIKE'] = '%'.$pasta.'%';
			}			
		
			if (!empty($status_id)) {
				$condicoes['PatenteInternacional.status_id'] = $status_id;
			}

			if (!empty($anoDe)) {
				if (!empty($anoAte)) {
					$condicoes['AND']['YEAR(PatenteInternacional.data_internacional) >='] = $anoDe;
					$condicoes['AND']['YEAR(PatenteInternacional.data_internacional) <='] = $anoAte;
				}else{

				}
			}elseif(!empty($anoAte)){

			}



			// ANOS //
			$params = array(
				'fields'=>array('DISTINCT(YEAR(PatenteInternacional.data_internacional)) as ano'),
				'order' => array('PatenteInternacional.data ASC'),
				'recursive' => 0
			);
			
			$anosTmp = $this->PatenteInternacional->find('all', $params);
			$anos = array();
			
			for ($i=0; $i < count($anosTmp); $i++) {
				$anos[$anosTmp[$i][0]['ano']] = $anosTmp[$i][0]['ano'];
			}
			$desdes = $ates = $anos;

			$status = $this->PatenteInternacional->Status->find('list');

			$patentes = $this->PatenteInternacional->find('all',array('conditions'=>$condicoes));
			
			//debug($condicoes); exit;
			$this->set(compact('patentes','status','desdes','ates'));
		}else{
			// ANOS //
			$params = array(
				'fields'=>array('DISTINCT(YEAR(PatenteInternacional.data_internacional)) as ano'),
				'order' => array('PatenteInternacional.data ASC'),
				'recursive' => 0
			);
			$anosTmp = $this->PatenteInternacional->find('all', $params);
			$anos = array();
			
			for ($i=0; $i < count($anosTmp); $i++) {
				$anos[$anosTmp[$i][0]['ano']] = $anosTmp[$i][0]['ano'];
			}

			$desdes = $ates = $anos;
			$status = $this->PatenteInternacional->Status->find('list');
			$this->set(compact('status','desdes','ates'));
		}

	}


	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for tecnologia', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->PatenteInternacional->delete($id, true)) {
			$this->Session->setFlash(__('Tecnologia deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Tecnologia was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

	function ajaxPct() {
		$this->layout = '';
		$this->autoRender = false;
		$this->PatenteInternacional->Tecnologia->recursive = -1;

		$query = $_GET['q'];
		
		$pedidos = $this->PatenteInternacional->find('all',array('conditions' => array('AND' => array('PatenteInternacional.num_pedido LIKE' => '%'.$query.'%', 'PatenteInternacional.natureza_id LIKE' => '1')),
														'fields' => array('PatenteInternacional.id', 'PatenteInternacional.titulo AS name', 'PatenteInternacional.num_pedido'),
														'limit'=>10
														)
										);
		
		$resultado = array();

		foreach ($pedidos as $pedido) {
			array_push($resultado, $pedido['PatenteInternacional']);
		}

		return json_encode($resultado);
	}

	function ajaxAssociarTitular() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$titular_id = $_GET['id'];
		$patente_internacional_id = $_GET['tec_id'];
		
		// checa para ver se este autor já não está associado a esta tecnologia antes
		$query = sprintf("
		SELECT * FROM patentes_internacionais_titulares 
		WHERE titular_id=%d AND patente_internacional_id=%d
		LIMIT 1", 
		$titular_id, $patente_internacional_id );
		$resultado = $this->PatenteInternacional->query($query);

		if ( count($resultado) ) {
			// houve resultado na busca, indicando que tentou-se repetir uma associação
			// retorna um JSON com o erro
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __($query, true) );
			exit;
		}
		
		$query = sprintf("
		INSERT INTO patentes_internacionais_titulares (
			patente_internacional_id,
			titular_id
		) VALUES (%d, %d)", 
		$patente_internacional_id, $titular_id );
		$resultado = $this->PatenteInternacional->query($query);

		
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
		$patente_internacional_id = $_GET['tec_id'];
		
		$query = sprintf("DELETE FROM patentes_internacionais_titulares WHERE patente_internacional_id = %d AND titular_id = %d LIMIT 1", $patente_internacional_id, $titular_id);
		$resultado = $this->PatenteInternacional->query($query);
		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Titular desassociado com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao desassociar este inventor. Saia do sistema e tente novamente.", true) );
		}
		
	}//ajaxDesassociarTitular

	function ajaxAssociarDepartamento() {
		Configure::write('debug', 2);
		$this->autoRender = false;
		
		$departamento_id = $_GET['id'];
		$unidade_id = $_GET['uni_id'];
		$patente_internacional_id = $_GET['tec_id'];
		
		// checa para ver se este autor já não está associado a esta tecnologia antes
		$query = sprintf("
		SELECT * FROM departamentos_patentes_internacionais 
		WHERE departamento_id=%d AND patente_internacional_id=%d
		LIMIT 1", 
		$departamento_id, $patente_internacional_id);
		$resultado = $this->PatenteInternacional->query($query);

		if ( count($resultado) ) {
			// houve resultado na busca, indicando que tentou-se repetir uma associação
			// retorna um JSON com o erro
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __($query, true) );
			exit;
		}
		
		$query = sprintf("
		INSERT INTO departamentos_patentes_internacionais (
			patente_internacional_id,
			departamento_id,
			unidade_id
		) VALUES (%d, %d, %d)", 
		$patente_internacional_id, $departamento_id, $unidade_id);
		$resultado = $this->PatenteInternacional->query($query);

		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Origem associada com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __($query, true) );
		}
		
	}//ajaxAssociarDepartamento

	function ajaxDesassociarDepartamento() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$departamento_id = $_GET['id'];
		$patente_internacional_id = $_GET['tec_id'];
		
		$query = sprintf("DELETE FROM departamentos_patentes_internacionais WHERE patente_internacional_id = %d AND departamento_id = %d LIMIT 1", $patente_internacional_id, $departamento_id);
		$resultado = $this->PatenteInternacional->query($query);
		
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
		$patente_internacional_id = $_GET['tec_id'];
		
		// checa para ver se este autor já não está associado a esta tecnologia antes
		$query = sprintf("
		SELECT * FROM inventores_patentes_internacionais 
		WHERE inventor_id=%d AND patente_internacional_id=%d
		LIMIT 1", 
		$inventor_id, $patente_internacional_id );
		$resultado = $this->PatenteInternacional->query($query);
		
		if ( count($resultado) ) {
			// houve resultado na busca, indicando que tentou-se repetir uma associação
			// retorna um JSON com o erro
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Este inventor já está associado com esta tecnologia.", true) );
			exit;
		}
		
		$query = sprintf("
		INSERT INTO inventores_patentes_internacionais (
			inventor_id,
			patente_internacional_id
		) VALUES (%d, %d)", 
		$inventor_id, $patente_internacional_id );
		$resultado = $this->PatenteInternacional->query($query);
		
		// Não utilizei o sistema abaixo pois o cake apagava o restante das associações, a não ser q eu buscasse antes os outros inventores e gerasse o array com eles
		// gera array de associação
		// $data = array();
		// $data['Tecnologia'] = array('id' => $tecnologia_id);
		// $data['Inventor'] = array('Inventor' => $inventor_id);
		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Inventor associado com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao associar este inventor. Saia do sistema e tente novamente.", true) );
		}
		
	}//ajaxAssociarInventor

	function ajaxDesassociarInventor() {
		Configure::write('debug', 0);
		$this->autoRender = false;
		
		$inventor_id = $_GET['id'];
		$patente_internacional_id = $_GET['tec_id'];
		
		$query = sprintf("DELETE FROM inventores_patentes_internacionais WHERE patente_internacional_id = %d AND inventor_id = %d LIMIT 1", $patente_internacional_id, $inventor_id);
		$resultado = $this->PatenteInternacional->query($query);
		
		if ( $resultado ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 1, __("Inventor desassociado com sucesso.", true) );
		} else {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, __("Houve um erro ao desassociar este inventor. Saia do sistema e tente novamente.", true) );
		}
		
	}//ajaxDesassociarInventor

	function ajaxAdicionarArquivos($id = null) {
		// Reference general return: printf(json_encode(var_export($this->data, true)));exit;
		Configure::write('debug', 0);
		$this->autoRender = false;

		// printf(json_encode(var_export($this->data, true)));exit;
		
		/*
			array ( 'Tecnologia' =&gt; array ( 'arquivo' =&gt; array ( 'name' =&gt; 'conflictvotes.sql', 'type' =&gt; 'application/octet-stream', 'tmp_name' =&gt; '/Applications/MAMP/tmp/php/phpo3OsT9', 'error' =&gt; 0, 'size' =&gt; 800, ), ), )
		*/

		if ( empty($this->data) /*|| empty($this->data['Tecnologia']['arquivo']['tmp_name'])*/ ) {
			printf('{"sucesso":%d, "retorno":"%s"}', 0, 'Favor enviar um arquivo.');exit;
		}

		// initialize the upload object
		$this->Upload->upload( $this->data['PatenteInternacional']['arquivo'] );


		$uuid = String::uuid();
		$filename = $uuid;
		
		$nomeOriginal = $this->data['PatenteInternacional']['arquivo']['name'];
		$mimetype     = $this->data['PatenteInternacional']['arquivo']['type'];

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
		$saving['Arquivo']['patente_internacional_id'] = $id;
		$saving['Arquivo']['mimetype']      = $mimetype;
		$this->PatenteInternacional->Arquivo->create();
		$this->PatenteInternacional->Arquivo->save($saving);

		printf('{"sucesso":%d, "nomeOriginal":"%s", "id":"%s"}', 1, $nomeOriginal, $filename);exit;
	}

/*
	function multipleAdd($numeroPatentes = null){
		if (!empty($this->data)) {
			
			debug($this->data);

			/*if(isset($this->data['Tecnologia']['internacional'])){
				$this->Tecnologia->set('nacional_id',$pedido_nacional['Tecnologia']['id']);
				$this->Tecnologia->set('pais',$pedido_nacional['Tecnologia']['pais']);
			}else{
				$this->Tecnologia->set('nacional_id',$this->data['Tecnologia']['num_pedido']);
				$this->Tecnologia->set('pais','2');
			}*/

			/*if ($this->Tecnologia->save($this->data)) {
				$this->Session->setFlash(__('The tecnologia has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tecnologia could not be saved. Please, try again.', true));
			}
		}
		$naturezatecnologias = $this->Tecnologia->NaturezaTecnologia->find('list'); 
		$areas = $this->Tecnologia->Area->find('list');
		$status = $this->Tecnologia->Status->find('list');
		$inventores = $this->Tecnologia->Inventor->find('list');
		$users = $this->Tecnologia->User->find('list', array('conditions' => array('User.group_id' => '2')));
		$paises = $this->Tecnologia->Pais->find('list');
		$this->set(compact('areas', 'status', 'inventores','users','naturezatecnologias','paises', 'numeroPatentes'));

	}*/
	

}
?>
