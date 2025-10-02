<?php
class GraficosController extends AppController {
	
	var $name = 'Graficos';

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('desenhosPorAno', 'patentesPorAno','marcasPorAno','softwaresPorAno','knowhowsPorAno','patentesPorArea','patentesPorUnidade','patentesPorDepartamento'));
	}
		
	function index() {
		App::Import('Model','Tecnologia');
		$tecnologia = new Tecnologia();
	}
	
	function patentesPorAno() {
		Configure::write('debug', 0);
		$this->layout = '';
		
		App::Import('Model','Tecnologia');
		$tecnologia = new Tecnologia();
		
		$query = "SELECT YEAR(data) as ano, COUNT(*) as total from tecnologias GROUP BY YEAR(data)";
		$resultado = $tecnologia->query($query);
		$this->set(compact('resultado'));
	}

	function marcasPorAno() {
		Configure::write('debug', 0);
		$this->layout = '';

		App::Import('Model','Marca');
		$marca = new Marca();

		$query = "SELECT YEAR(data) as ano, COUNT(*) as total from marcas GROUP BY YEAR(data)";
		$resultado = $marca->query($query);
		$this->set( compact('resultado') );
	}

	function softwaresPorAno() {
		Configure::write('debug', 0);
		$this->layout = '';

		App::Import('Model','Software');
		$software = new Software();

		$query = "SELECT YEAR(data) as ano, COUNT(*) as total from softwares GROUP BY YEAR(data)";
		$resultado = $software->query($query);
		$this->set( compact('resultado') );
	}

	function knowhowsPorAno() {
		Configure::write('debug', 0);
		$this->layout = '';

		App::Import('Model','Knowhow');
		$knowhow = new Knowhow();

		$query = "SELECT YEAR(data) as ano, COUNT(*) as total from knowhows GROUP BY YEAR(data)";
		$resultado = $knowhow->query($query);
		$this->set( compact('resultado') );
	}

	function desenhosPorAno() {
		Configure::write('debug', 0);
		$this->layout = '';

		App::Import('Model','Desenho');
		$desenho = new Desenho();

		$query = "SELECT YEAR(data) as ano, COUNT(*) as total from desenhos GROUP BY YEAR(data)";
		$resultado = $desenho->query($query);
		$this->set( compact('resultado') );
	}

	function patentesPorMes() {
		Configure::write('debug', 0);
		$this->layout = '';
		
		App::Import('Model','Tecnologia');
		$tecnologia = new Tecnologia();
		
		//$query = "SELECT YEAR(data) as ano, MONTH(data) as mes, COUNT(*) as total from tecnologias GROUP BY YEAR(data), MONTH(data)";
		$query = "SELECT YEAR(data) as ano, MONTH(data) as mes, COUNT(*) as total from tecnologias WHERE data > DATE_SUB(NOW(), INTERVAL 3 YEAR) GROUP BY YEAR(data), MONTH(data)";
		$resultado = $tecnologia->query($query);
		$this->set( compact('resultado') );
	}
	
	function patentesPorArea($lingua = 1) { //se lingua = 1 é Português, caso contrário, é inglês
		// Configure::write('debug', 0);
		$this->layout = '';
		
		App::Import('Model','Tecnologia');
		$tecnologia = new Tecnologia();
		
		if ($lingua == 1) {
			$query = "SELECT a.nome as area, COUNT(*) as total from tecnologias t, areas a WHERE t.area_id = a.id GROUP BY a.nome ORDER BY total DESC";
		} else {
			$query = "SELECT a.name as area, COUNT(*) as total from tecnologias t, areas a WHERE t.area_id = a.id GROUP BY a.name ORDER BY total DESC";
		}
		
		$resultado = $tecnologia->query($query);
		$this->set( compact('resultado') );
	}

	function patentesPorUnidade() {
		// Configure::write('debug', 0);
		$this->layout = '';
		
		App::Import('Model','Tecnologia');
		$tecnologia = new Tecnologia();
		
		$query = "SELECT a.nome, a.id, count(*) as total FROM (SELECT *
																FROM departamentos_tecnologias dt, unidades u
																WHERE u.id = dt.unidade_id
																GROUP BY dt.tecnologia_id, dt.unidade_id) as a
																GROUP BY a.nome
																ORDER BY total DESC";

		$resultado = $tecnologia->query($query);
		

		$this->set( compact('resultado') );
	}

	function patentesPorDepartamento() {
		// Configure::write('debug', 0);
		$this->layout = '';
		
		App::Import('Model','Tecnologia');
		$tecnologia = new Tecnologia();
		
		$query = "SELECT nome, departamentos.id, COUNT( tecnologia_id ) AS total
				  FROM departamentos_tecnologias JOIN departamentos ON departamento_id = departamentos.id
				  GROUP BY departamento_id
				  ORDER BY total DESC ";

		$resultado = $tecnologia->query($query);
		$this->set( compact('resultado') );
	}

	function graficoUnidade($id = NULL) {
		// Configure::write('debug', 0);
		
		/*App::Import('Model','Tecnologia');
		$tecnologia = new Tecnologia();
		
		$query = "SELECT a.nome, a.id, count(*) as total FROM (SELECT *
																FROM departamentos_tecnologias dt, departamentos d
																WHERE d.id = dt.departamento_id
																GROUP BY dt.tecnologia_id, dt.departamento_id) as a
																GROUP BY a.nome
																ORDER BY total DESC";

		$resultado = $tecnologia->query($query);
		$this->set( compact('resultado') );*/
	}
}
?>
