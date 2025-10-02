<?php
	//print_r($marcas);
	//exit();
?>
<script type="text/javascript">
	var ids_marcas = <?= isset($ids) ? $ids : '""' ?>;
</script>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Marcas', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nova Marca', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Buscar Marcas', true), array('action' => 'search')); ?></li>
	</ul>
</div>

<div class="Marcas index">
	<h2><?php __('Buscar Marcas');?></h2>
	
		<?php echo
			$this->Form->create('Marca', 
				array(
					'action' => 'search',
					//'inputDefaults' => array('label' => false, 'div' => false)
				)
			); 
		?>

		<fieldset>
		<?php
			echo $this->Form->input('nome', array('label' => 'Nome', 'type' => 'text'));
			echo $this->Form->input('processo', array('label' => 'Número do processo', 'type' => 'text'));
			echo $this->Form->input('pasta', array('label' => 'Pasta', 'type' => 'text'));
			echo $this->Form->input('pasta_juridico', array('label' => 'Pasta Jurídico', 'type' => 'text'));
			echo $this->Form->input('num_processo_sei', array('label' => 'Número do Processo SEI', 'type' => 'text'));

			echo $this->Form->input('titular_id', array('label' => 'Titular','empty'=>'Todos'));
			echo $this->Form->input('status_id', array('label' => 'Status','empty'=>'Todos'));

			$valores_status_transferenia = array('st_ofertada'=>'Ofertada','st_em_negociacao'=>'Em Negociação','st_licenciada'=>'Licenciada/Transferida','st_parceria'=>'Parceria','st_contrato_rescindido'=>'Contrato Rescindido','st_vitrine_tecnologica'=>'Vitrine Tecnológica');
			echo $this->Form->input('status_transferencia_id', array('label' => 'Status da Transferência','empty'=>'Todos', 'options'=>$valores_status_transferenia));
			echo $this->Form->input('andamento_id', array('label' => 'Andamento','empty'=>'Todos'));

			echo $this->Form->input('desde', array('label' => 'Desde'));
			echo $this->Form->input('ate', array('label' => 'Até'));
			//echo $this->Form->input('desde', array('type' => 'select','empty' => __('Todos', true), 'label' => 'De' ));
			//echo $this->Form->input('ate', array('type' => 'select','empty' => __('Todos', true), 'label' => 'Até' ));
			// echo $this->Form->year('ano', 1920, date('Y'), 1950);
		?>
			<?php echo $this->Form->end(__('Submit', true));?>
		</fieldset>
	
	<?php if (!empty($marcas)): ?>
		<?php if (count($marcas)>1): ?>
			<h3><?php printf(__('Foram encontradas <strong>%d</strong> marcas com os critérios de busca escolhidos.', true),count($marcas)) ?></h3>
		<?php else: ?>
			<h3><?php printf(__('Foi encontrada <strong>%d</strong> marca com os critérios de busca escolhidos.', true),count($marcas)) ?></h3>
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
					<th><?php echo __('Nome');?></th>
					<th><?php echo __('Processo');?></th>
					<th><?php echo __('Pasta');?></th>
					<th><?php echo __('Data');?></th>
					<th class="actions"><?php __('Actions');?></th>
			</tr>
		<?php
		$i = 0;
		foreach ($marcas as $marca):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		
		<tr<?php echo $class;?>>
			<td class="num"><?php echo $i ?>&nbsp;</td>

			<td class="nome_marca">
				<?php echo $marca['Marca']['nome']; ?>
			</td>

			<td class="processo">
				<?php printf( '<p>%s</p><p style="color:#777;margin-top:5px"></p>', $marca['Marca']['processo']) ?>&nbsp;
			</td>
			<?php
				if(!$marca['Marca']['pasta']) {
					$marca['Marca']['pasta'] = '-';
				}
			?>
			<td class="processo">
				<?php printf( '<p>%s</p><p style="color:#777;margin-top:5px"></p>', $marca['Marca']['pasta']) ?>&nbsp;
			</td>
			<td class="data"><?php echo $time->format('d.m.Y', $marca['Marca']['data']); ?>&nbsp;</td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('action' => 'view', $marca['Marca']['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $marca['Marca']['id'])); ?>
				<?php echo $this->Html->link(__('Excluir', true), array('action' => 'delete', $marca['Marca']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $marca['Marca']['id'])); ?>
			</td>
		</tr>
		<?php endforeach; ?>
		</table>
	<?php elseif (isset($marcas)): ?>
		<h3>Sua busca não gerou resultados.</h3>
	<?php endif; ?>
</div>
<script>
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
	    $('#btn_exportar_resultados').click(function() {
  			$("#campos_exportacao").toggle();
		});

		$('#btn_enviar_campos_exportacao').click(function (){
			$.ajax({
    			type:'POST',
    			url:"./exportar",
    			data: {
              			ids : ids_marcas,
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

		$("#MarcaDesde").mask("99/99/9999");
		$("#MarcaAte").mask("99/99/9999");
	});
</script>