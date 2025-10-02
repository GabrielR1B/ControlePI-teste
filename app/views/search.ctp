<script type="text/javascript">
	var ids_tecnologias = <?= $ids; ?>;
</script>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Patentes', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nova Patente', true), array('action' => 'add')); ?> </li>
	</ul>
</div>

<div class="tecnologias index">
	<h2><?php __('Buscar Patentes');?></h2>
	
		<?php echo
			$this->Form->create('Tecnologia', 
				array(
					'action' => 'search'
				)
			); 
		?>

		<fieldset>
		<?php
			echo $this->Form->input('pasta', array('label' => 'Pasta', 'type' => 'text'));
			echo $this->Form->input('pasta_juridico', array('label' => 'Pasta Jurídico', 'type' => 'text'));
			echo $this->Form->input('num_pedido', array('label' => 'Número do pedido', 'type' => 'text'));
			echo $this->Form->input('titulo', array('label' => 'Título', 'type' => 'text'));
			echo $this->Form->input('resumo', array('label' => 'Resumo', 'type' => 'text'));
			echo $this->Form->input('reivindicacoes', array('label' => 'Quadro Reivindicatório', 'type' => 'text'));

			echo '<div class="input"><label>Número de Reivindicações</label>';
			echo $this->Form->text('num_reivindicacoes', array('type'=>'number'));
			echo '</div>';

			echo $this->Form->input('num_processo_sei',array('label'=>'Número do Processo SEI'));
			echo $this->Form->input('area_id', array('empty' => __('Todas', true) ));
			echo $this->Form->input('area_conhecimento_id', array('empty' => __('Todas', true),'options'=>$areas_conhecimento));
			echo $this->Form->input('titular_id', array('empty' => __('Todos', true) ));
			echo $this->Form->input('acompanhamento_id', array('empty' => __('Todos', true),'options'=>array('1'=>'UFMG','2'=>'Terceiros')));
			echo $this->Form->input('status_id', array('empty' => __('Todos', true)));
			echo $this->Form->input('status_transferencia_id', array('empty' => __('Todos', true),'options'=> $status_transferencia ));
			echo $this->Form->input('unidade_id', array('empty' => __('Todas', true) ));
			echo $this->Form->input('departamento_id', array('empty' => __('Todos', true) ));
			echo $this->Form->input('andamento_id', array('empty' => __('Todos', true) ));
			echo $this->Form->input('Inventor', array('type' => 'select','empty' => __('Todos', true) ));
			echo $this->Form->input('redator_id', array('label'=>'Redator', 'type' => 'select','empty' => __('Todos', true) ));
			//echo $this->Form->input('desde', array('label'=>'Data de Início', 'type' => 'date'));
			echo $this->Form->input('mesDe', array('type' => 'select', 'class' => 'mesDe','empty' => __('Mês', true), 'label' => 'De' ));
			echo $this->Form->input('desde', array('type' => 'select', 'class' => 'anoDe', 'empty' => __('Ano', true), 'label' => '' ));
			echo $this->Form->input('mesAte', array('type' => 'select', 'class' => 'mesAte','empty' => __('Mês', true), 'label' => 'Até' ));
			echo $this->Form->input('ate', array('type' => 'select', 'class' => 'anoAte','empty' => __('Ano', true), 'label' => '' ));		
			echo $this->Form->input('prioridade_interna', array('type'=>'checkbox','format' => array('before', 'input', 'between', 'label', 'after', 'error' )));
			echo $this->Form->input('pct', array('type'=>'checkbox','label'=>'PCT'));
            echo $this->Form->input('palavrachave',array('id'=>'palavrachave_id_input','label'=>'Palavras-chave')); 
		?>
			<label>Operador Lógico das Palavras-chave</label>
			<select name="data[Tecnologia][operador]">
				Operador
  				<option value="1">AND</option>
  				<option value="0">OR</option>
			</select>
			<br>
			<br>
			<?php echo $this->Form->end(__('Submit', true));?>
		</fieldset>
	
	<?php if (!empty($tecnologias)): ?>
		<?php if (count($tecnologias)>1): ?>
			<h3><?php printf(__('Foram encontradas <strong>%d</strong> patentes com os critérios de busca escolhidos.', true),count($tecnologias)) ?></h3>
		<?php else: ?>
			<h3><?php printf(__('Foi encontrada <strong>%d</strong> patente com os critérios de busca escolhidos.', true),count($tecnologias)) ?></h3>
		<?php endif; ?>
		
		<br>
		<?php echo $this->Form->end(array('label'=>'Exportar resultados','id'=>'btn_exportar_resultados'));?>		
		<div id="campos_exportacao" style="display: none">
			<br>
			<fieldset>
			<h4>Campos a serem exportados</h4>
			<table>
				<?php 
					echo "<tr><td><input id='marcar_todos' type='checkbox' checked>Marcar/Desmarcar todos</td><td></td><td></td></tr>";
					echo "<tr>";
					$count = 0;
					foreach ($colunas as $key => $coluna) {
						$count++;
						printf("<td><input class='field' type='checkbox' value='%s' %s>%s</td>",$coluna['field'], $coluna['checked'] ? 'checked' : '',$coluna['label']);
						if($count!= 0 && $count % 3 == 0){
							echo "</tr>";
							echo "<tr>";
						}
					}
					echo "<tr>";
				?>
			</table>
			<?php 
				echo $this->Form->input('nome_arquivo', array('type'=>'text','label'=>'Nome do Arquivo','default'=>'resultado_busca'));
				echo "<br>";
				echo $this->Form->end(array('id'=>'btn_enviar_campos_exportacao'));
			?>
			</fieldset>
		</div>		
		<br>

		<table cellpadding="0" cellspacing="0">
			<tr>
					<th><?php __('#');?></th>
					<th><?php echo __('Título');?></th>
					<th><?php echo __('Núm Pedido');?></th>
					<th><?php echo __('Data');?></th>
					<th><?php echo __('Andamento');?></th>
					<th><?php echo __('Titulares');?></th>
					<th><?php echo __('Status da Transferência');?></th>
					<th class="actions"><?php __('');?></th>
			</tr>
		<?php
		$i = 0;
		foreach ($tecnologias as $tecnologia):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		
		<tr<?php echo $class;?>>
			<td class="num"><?php echo $i ?>&nbsp;</td>
			<td class="titulo_tecnologia">
				<?php echo $tecnologia['Tecnologia']['titulo']; ?>
				<?php if (!empty($tecnologia['Inventor'])): ?>
					<?php $count = count($tecnologia['Inventor']) ?>
					<?php $k=1 ?>
					<div class="inventores">
						<p>
						<?php foreach ($tecnologia['Inventor'] as $inventor):	?>
							<?php echo $this->Html->link($inventor['nome'], array('controller' => 'inventores', 'action' => 'view', $inventor['id'])); ?><?php echo ($k<$count?' / ':'');  ?>						
							<?php $k++ ?>
						<?php endforeach; ?>
						</p>
						<div class="palavraschave">
							<?php
								//Coloca a tag de PCT, se tiver
								foreach ($tecnologia['PatenteInternacional'] as $key => $patenteInternacional)
								{
									if($patenteInternacional['natureza_id'] == 1){
										echo "<a>PCT</a>";
									}
									break;
								}
								//Coloca a tag de Prioridade Interna, se tiver
								if($tecnologia['PrioridadeInterna']['id'])
								{
									if(strtotime($tecnologia['Tecnologia']['data']) < strtotime($tecnologia['PrioridadeInterna']['data'])){
										echo "<a>Pedido Posterior</a>";
									}else{
										echo "<a>Prioridade Interna</a>";
									}
								}
								//Coloca a tag de Certificado de Adição, se tiver
								if($tecnologia['Tecnologia']['tem_certificado_adicao'] == 1)
								{
									echo "<a>Certificado de Adição</a>";
								}
							?>
						</div>
					</div>
				<?php endif; ?>
			</td>
			<td class="num_pedido">
				<?php
					if(!$tecnologia['Tecnologia']['pasta']) {
						$tecnologia['Tecnologia']['pasta'] = '-';
					}
				?>
				<?php printf( '<p>%s</p><p style="color:#777;margin-top:5px"> pasta: %s</p>', $tecnologia['Tecnologia']['num_pedido'], $tecnologia['Tecnologia']['pasta']) ?>&nbsp;
			</td>
			<td class="data"><?php echo $time->format('d.m.Y', $tecnologia['Tecnologia']['data']); ?>&nbsp;</td>
			<td>
				<?php
					echo $andamentos[$tecnologia['Andamento']['id']];
				?>
			</td>
			<td style="line-height: 15pt;">
				<?php
					foreach ($tecnologia['Titular'] as $key => $titular) {
						echo $titular['nome'].'<br>';
					}
				?>
			</td>
			<td>
				<?php
					echo $tecnologia['Tecnologia']['st_ofertada'] == '1' ? 'Ofertada<br>' : '';
					echo $tecnologia['Tecnologia']['st_em_negociacao'] == '1' ? 'Em negociaçao<br>' : '';
					echo $tecnologia['Tecnologia']['st_licenciada'] == '1' ? 'Licenciada/Transferida<br>' : '';
					echo $tecnologia['Tecnologia']['st_parceria'] ? 'Parceria<br>' : '';
					echo $tecnologia['Tecnologia']['st_contrato_rescindido'] ? 'Contrato Rescindido<br>' : '';
					echo $tecnologia['Tecnologia']['st_vitrine_tecnologica'] ? 'Vitrine Tecnológica<br>' : '';
				?>
			</td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('action' => 'view', $tecnologia['Tecnologia']['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $tecnologia['Tecnologia']['id'])); ?>
				<?php echo $this->Html->link(__('Excluir', true), array('action' => 'delete', $tecnologia['Tecnologia']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $tecnologia['Tecnologia']['id'])); ?>
			</td>
		</tr>
		<?php endforeach; ?>
		</table>
	<?php elseif (isset($tecnologias)): ?>
		<h3>Sua busca não gerou resultados.</h3>
	<?php endif; ?>
</div>
<script>

	<?php
		if(isset($populate_palavras_chave)){
			echo "populate_palavras_chave = ".json_encode($populate_palavras_chave);
		}else{
			echo "populate_palavras_chave = []";
		}
	?>

	function getSelectedFields(){
		var fields = [];

		$('.field:checked:checked').each(function () { 
			fields.push($(this).prop("value")); 
		});

		return fields;
	}

	function GetNomeArquivo(){
		return $('#nome_arquivo').val()+".xlsx";
	}

	$( "#marcar_todos" ).click(function() {
  		$('.field').click();
	});

	$(document).ready(function () {
	    	 	palavras_chave_input = $("#palavrachave_id_input").tokenInput('/controle-pi/palavraschave/ajaxSearch/', {
	    			hintText: "Digite as palavras-chave desejadas",
	    			preventDuplicates: true,
	    			propertyToSearch: "palavra",
	    			prePopulate: populate_palavras_chave,
	    			resultsFormatter: function(item){ return "<li>" + item.palavra + "</li>" }
	    			
	    		});

	    		$('#btn_exportar_resultados').click(function() {
  					$("#campos_exportacao").toggle();
				});

				$('#btn_enviar_campos_exportacao').click(function (){
					$.ajax({
    					type:'POST',
    					url:"./exportar",
    					data: {
                			ids : ids_tecnologias,
                			fields : getSelectedFields()
            			},
    					dataType:'json'
					}).done(function(data){
    					var $a = $("<a>");
    					$a.attr("href",data.file);
    					$("body").append($a);
    					$a.attr("download",GetNomeArquivo());
    					$a[0].click();
    					$a.remove();
					});
				});
	});

</script>
