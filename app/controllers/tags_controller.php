<?php
class TagsController extends AppController {
	
	function index() {		
		echo "acesse a função buildTags";exit;
	}
	
	function buildTags() {
		App::Import('Model','Tecnologia');
		$tec = new Tecnologia();
		$tec->Behaviors->attach('Containable');
		
		App::Import('Model','Palavrachave');
		$palavrachave = new Palavrachave();
		$palavrachave->Behaviors->attach('Containable');
		
		$tec->contain( array('Palavrachave') );
		$params = array(
			'order' => 'Tecnologia.data DESC',
			'fields' => array('Tecnologia.titulo')
		);
		
		// pegar o título de todas as tecnologias
		$tecs = $tec->find('all', $params);
		
		// loopar por todos os títulos individualmente
		for ( $i=0; $i<count($tecs); $i++ )
		{
			$titulo = $tecs[$i]['Tecnologia']['titulo'];
			$palavras = explode(" ", $titulo); // explodir o título em palavras isoladas com base no caracter "espaço"
			$palavras = $this->_limparPalavras($palavras);
			
			// testar cada palavra do título para ver se é ou não uma possível palavra-chave
			for ( $j=0; $j<count($palavras); $j++ )
			{
				$palavra = $palavras[$j];
				if ( strlen($palavra) < 4 ) 
				{
					// se a palavra tiver menos do que 4 caracteres, pular e passar para a próxima
					continue;
				}//if
				
				// checar se a palavra em questão já não existe no banco de dados
				$palavrachave->contain();
				$resultado = $palavrachave->findByPalavra($palavra);

				// Se a palavra-chave não existe ainda precisamos cadastra-la
				if ( !$resultado ) {
					// buscar todas as tecnologias onde esta palavra chave aparece no título
					$query = sprintf(
														"SELECT id from tecnologias
														WHERE MATCH(titulo) against('%s')",
														$palavra
												  );

					$tec->contain(); // ligar o containable behavior (recursive = -1)
					$matchedTecs = $tec->query($query);
					// print_r($matchedTecs);exit;
					
					// adicionar a palavra chave ao banco
					$this->data['Palavrachave']['palavra'] = $palavra;
					$palavrachave->create();
					$palavrachave->save($this->data);
					$palavrachave_id = $palavrachave->id; // pega o ID da palavra-chave q foi salva
					
					// armazena na tabela palavraschave_tecnologias o relacionamento do que foi encontrado
					// e portanto associando a palavra-chave às tecnologias encontradas
					for ( $k=0; $k<count($matchedTecs); $k++ )
					{
						$tec_id = $matchedTecs[$k]['tecnologias']['id'];
						
						$query = sprintf("
						INSERT INTO palavraschave_tecnologias (
							palavrachave_id,
							tecnologia_id
						) VALUES (%d, %d)", 
						$palavrachave_id, $tec_id );
						$resultado = $palavrachave->query($query);
						// print_r($resultado);exit;
					}// for $k
					
				}//if
				
			}//for $j
		}// for $i
		
		$this->_removerPalavrasChave(); // remover palavras-chave com 1 ou menos associações
		print_r('Todas as palavras-chave foram detectadas e associadas automaticamente');exit;
	}
	
	
	// remover as palavras chave q aparecem somente 1 ou menos vezes
	function _removerPalavrasChave() {
		App::Import('Model','Palavrachave');
		$palavrachave = new Palavrachave();
		
		$query = "
			SELECT p.id AS id, p.palavra AS palavra, count(pt.palavrachave_id) AS total
			FROM palavraschave p LEFT JOIN palavraschave_tecnologias pt
			ON p.id = pt.palavrachave_id GROUP BY p.id
			HAVING count(pt.palavrachave_id) < 2
			ORDER BY total ASC, palavra ASC
		";

		$resultado = $palavrachave->query($query);
		// print_r($resultado);exit;
		
		for ( $i=0; $i<count($resultado); $i++ ) {
			$id = $resultado[$i]['p']['id'];
			$palavrachave->delete($id);
		}
		
	}
	
	function _limparPalavras($palavras) {
		for ( $i=0; $i<count($palavras); $i++ ) {
			$palavra = $palavras[$i];
			
			$invalidos = array(",", "(", ")", ":", ".");
			$palavra = str_replace($invalidos, "", $palavra);
			$palavras[$i] = $palavra;
		}
		return $palavras;
	}
	
}
?>