<?php
class PublicacoesController extends AppController {

	var $name = 'Publicacoes';

	var $paginate = array(
		'limit' => 50,
		'order' => array(
			'Publicacao.id' => 'desc',
		)
	);
	
	function index() {
		$data = array('Publicacao'=>array());

		$condicoes = array();
		$condicoes['Tecnologia.status_id'] = array('NULL','1');

		if(isset($this->params['url']['rpi_inicial']) && $this->params['url']['rpi_inicial']!=''){
			$condicoes['Publicacao.num_rpi >='] = $this->params['url']['rpi_inicial'];
			$data['Publicacao']['rpi_inicial'] = $this->params['url']['rpi_inicial'];
		}

		if(isset($this->params['url']['rpi_final']) && $this->params['url']['rpi_final']!=''){
			$condicoes['Publicacao.num_rpi <='] = $this->params['url']['rpi_final'];
			$data['Publicacao']['rpi_final'] = $this->params['url']['rpi_final'];	
		}

		if(isset($this->params['url']['data_publicacao_inicial']) && $this->params['url']['data_publicacao_inicial']!=''){
			$data_publicacao_inicial = date_parse_from_format("d/m/Y", $this->params['url']['data_publicacao_inicial']);
			if(!checkdate($data_publicacao_inicial['month'], $data_publicacao_inicial['day'], $data_publicacao_inicial['year'])){
				$this->Session->setFlash(__('Data de publicação inicial inválida', true));
				$this->redirect(array('action' => 'index'));
			}
			$condicoes['Rpi.data_publicacao >='] = sprintf('%d-%d-%d',$data_publicacao_inicial['year'],$data_publicacao_inicial['month'],$data_publicacao_inicial['day']);	
			$data['Publicacao']['data_publicacao_inicial'] = $this->params['url']['data_publicacao_inicial'];	
		}

		if(isset($this->params['url']['data_publicacao_final']) && $this->params['url']['data_publicacao_final']!=''){
			$data_publicacao_final = date_parse_from_format("d/m/Y", $this->params['url']['data_publicacao_final']);
			if(!checkdate($data_publicacao_final['month'], $data_publicacao_final['day'], $data_publicacao_final['year'])){
				$this->Session->setFlash(__('Data de publicação final inválida', true));
				$this->redirect(array('action' => 'index'));
			}
			$condicoes['Rpi.data_publicacao <='] = sprintf('%d-%d-%d',$data_publicacao_final['year'],$data_publicacao_final['month'],$data_publicacao_final['day']);	
			$data['Publicacao']['data_publicacao_final'] = $this->params['url']['data_publicacao_final'];
		}

		if(isset($this->params['url']['data_vencimento_inicial']) && $this->params['url']['data_vencimento_inicial']!=''){
			$data_vencimento_inicial = date_parse_from_format("d/m/Y", $this->params['url']['data_vencimento_inicial']);
			if(!checkdate($data_vencimento_inicial['month'], $data_vencimento_inicial['day'], $data_vencimento_inicial['year'])){
				$this->Session->setFlash(__('Data de vencimento inicial inválida', true));
				$this->redirect(array('action' => 'index'));
			}
			$condicoes['Publicacao.prazo >='] = sprintf('%d-%d-%d',$data_vencimento_inicial['year'],$data_vencimento_inicial['month'],$data_vencimento_inicial['day']);	
			$condicoes['Publicacao.status_providencia_id ='] = 2;
			$data['Publicacao']['data_vencimento_inicial'] = $this->params['url']['data_vencimento_inicial'];
		}

		if(isset($this->params['url']['data_vencimento_final']) && $this->params['url']['data_vencimento_final']!=''){
			$data_vencimento_final = date_parse_from_format("d/m/Y", $this->params['url']['data_vencimento_final']);
			if(!checkdate($data_vencimento_final['month'], $data_vencimento_final['day'], $data_vencimento_final['year'])){
				$this->Session->setFlash(__('Data de vencimento final inválida', true));
				$this->redirect(array('action' => 'index'));
			}
			$condicoes['Publicacao.prazo <='] = sprintf('%d-%d-%d',$data_vencimento_final['year'],$data_vencimento_final['month'],$data_vencimento_final['day']);	
			$condicoes['Publicacao.status_providencia_id ='] = 2;
			$data['Publicacao']['data_vencimento_final'] = $this->params['url']['data_vencimento_final'];
		}

		if(isset($this->params['url']['despacho_id']) && $this->params['url']['despacho_id']!=''){
			$condicoes['Publicacao.codigo_despacho ='] = $this->params['url']['despacho_id'];	
			$data['Publicacao']['despacho_id'] = $this->params['url']['despacho_id'];
		}

		if(isset($this->params['url']['pasta']) && $this->params['url']['pasta']!=''){
			$condicoes['Tecnologia.pasta ='] = $this->params['url']['pasta'];	
			$data['Publicacao']['pasta'] = $this->params['url']['pasta'];
		}

		if(isset($this->params['url']['exibir_arquivo_morto']) && $this->params['url']['exibir_arquivo_morto']=='1'){
			unset($condicoes['Tecnologia.status_id !=']);
			$data['Publicacao']['exibir_arquivo_morto'] = $this->params['url']['exibir_arquivo_morto'];
		}

		if(isset($this->params['url']['somente_pendentes']) && $this->params['url']['somente_pendentes']=='1'){
			$condicoes['Publicacao.status_providencia_id ='] = 2;
			$data['Publicacao']['somente_pendentes'] = $this->params['url']['somente_pendentes'];
		}

		$this->Publicacao->recursive = 1;
		$this->set('publicacoes', $this->paginate('Publicacao', $condicoes));
		$this->set('despachos', $this->Publicacao->Despacho->find('list'));
		$this->data = $data;
	}
	
	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid area', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Publicacao->recursive = 2;
		
		$publicacao = $this->Publicacao->findById($id);
		// debug($inventor);
		$this->set('publicacao',$publicacao);
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
			if ($this->Publicacao->save($this->data)) {
				$this->Session->setFlash(__('The area has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The area could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Publicacao->read(null, $id);
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

	function cumprir($id) {
		//print_r($id);
		//exit();
		$publicacao = $this->Publicacao->findById($id);
		$publicacao['Publicacao']['status_providencia_id'] = 3;
		$this->Publicacao->save($publicacao);
		$this->redirect(array('controller'=>'rpis','action' => 'view', $publicacao['Publicacao']['num_rpi']));
	}
}
?>