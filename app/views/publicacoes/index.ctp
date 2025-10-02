<?php
	//print_r($publicacoes);
	//exit();
?>
<script type="text/javascript">
	var ids_tecnologias = <?= $ids; ?>;
</script>
<style type="text/css">
	#PublicacaoRpiInicial, #PublicacaoRpiFinal, #PublicacaoDataPublicacaoInicial, #PublicacaoDataPublicacaoFinal, #PublicacaoDataVencimentoInicial, #PublicacaoDataVencimentoFinal, #PublicacaoPasta {
		width: 90%;
	}

	#PublicacaoDespachoId{
		height: 27px;
		width: 98%;
		font-size: 12px;
	}

	#search_table td{
  		border: 0px solid black;
	}

	.submit input{
		float: right;
	}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		$("#PublicacaoDataPublicacaoInicial").mask("99/99/9999");
		$("#PublicacaoDataPublicacaoFinal").mask("99/99/9999");
		$("#data_vencimento_inicial").mask("99/99/9999");
		$("#data_vencimento_final").mask("99/99/9999");

		$('#cumprir_lote').click(function(){
			var ids = [];
			$('.checkbox_lote:checked').each(function(){
				ids.push($(this).val());
			});

			//$.ajax({
			//	url: "./publicacoes/cumprir_lote?ids=" + , 
			//	success: function(result){
    		//		alert("sucesso");
  			//	}
  			//});

  			$.ajax({
    			type:'POST',
    			url:"./publicacoes/cumprir_lote",
    			data: {
                	ids : ids.join(',')
            	},
    			success: function(){
    				document.location.reload(true);
    			}
			});
		});

		$('#btn_exportar_resultados').click(function() {
  			$("#campos_exportacao").toggle();
		});

		$( "#marcar_todos" ).click(function() {
  			$('.field').click();
		});

		$('#btn_enviar_campos_exportacao').click(function (){
			$.ajax({
    			type:'POST',
    			url:"./publicacoes/exportar",
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

	function getSelectedFields(){
		var fields = [];

		$('.field:checked:checked').each(function () { 
			fields.push($(this).prop("value")); 
		});

		return fields;
	}

	function GetNomeArquivo(){
		return $('#PublicacaoNomeArquivo').val()+".xlsx";
	}
</script>
<h2>Publicações</h2>
<br><br>
<?php echo
			$this->Form->create('Publicacao', array('action' => 'index', 'type'=>'GET')); 
?>
	<table id="search_table">
		<tr>
			<td><?php echo $this->Form->input('rpi_inicial', array('label' => 'RPI Inicial', 'type' => 'text','maxlength'=>4)); ?></td>
			<td><?php echo $this->Form->input('rpi_final', array('label' => 'RPI Final', 'type' => 'text','maxlength'=>4)); ?></td>
			<td><?php echo $this->Form->input('data_publicacao_inicial', array('label' => 'Data de Publicação Inicial', 'type' => 'text')); ?></td>
			<td><?php echo $this->Form->input('data_publicacao_final', array('label' => 'Data de Publicação Final', 'type' => 'text')); ?></td>
			<!--=<td><br><br><?php echo $this->Form->input('exibir_arquivo_morto', array('label' => 'Exibir arquivo morto', 'type' => 'checkbox')); ?></td>-->
			<td>
				<?= $this->Form->input('status_id', array('label'=>'Status PI','options'=>$status, 'empty'=>'Todos', 'value'=>isset($status_id) ? $status_id : '')); ?>
			</td>
		</tr>
		<tr>
			<td><?php echo $this->Form->input('data_vencimento_inicial', array('label' => 'Data de Vencimento Inicial', 'type' => 'text')); ?></td>
			<td><?php echo $this->Form->input('data_vencimento_final', array('label' => 'Data de Vencimento Final', 'type' => 'text')); ?></td>
			<td colspan="2"><?php echo $this->Form->input('despacho_id', array('label' => 'Despacho','options'=>$despachos,'empty'=>'')); ?></td>
			<td style="height: 100%;"><br><br><?php echo $this->Form->input('somente_pendentes', array('label' => 'Somente pendentes', 'type' => 'checkbox')); ?></td>			
		</tr>
		<tr>
			<td><?php echo $this->Form->input('pasta', array('label' => 'Pasta', 'type' => 'text')); ?></td>
			<td><input type="submit" name="Filtrar" style="margin-top: 18px;"></td>
		</tr>
	</table>
</form>
<button id="btn_exportar_resultados" style="margin-bottom: 30px;">Exportar Resultados</button>
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
		echo $this->Form->input('nome_arquivo', array('type'=>'text','label'=>'Nome do Arquivo','default'=>'publicacoes'));
		echo "<br>";
		echo $this->Form->end(array('id'=>'btn_enviar_campos_exportacao'));
	?>
	</fieldset>
</div>
<div class="redator index">
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 	<?php echo $this->Paginator->numbers();?>
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>

	<table class="simples" cellpadding="0" cellspacing="0">
		<tr>
			<th></th>
			<th><?php echo "Pasta"; ?></th>
			<th><?php echo "RPI"; ?></th>
			<th><?php echo "Despacho";   ?></th>
			<th><?php echo "Tecnologia";   ?></th>
			<th><?php echo "Status";   ?></th>
			<th><?php echo "Prazo";   ?></th>
			<th><?php echo "Documentos";   ?></th>
			<th class="actions"><?php __('Actions');?></th>
		</tr>
		<?php
		$i = 0;
		$j = 0;
		$item =	1;
		foreach ($publicacoes as $publicacao):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td>
					<?php
						if(isset($publicacao['Tecnologia']['id'])){
							if($publicacao['Publicacao']['status_providencia_id']==2){
								echo $this->Form->input('checkbox',array('type'=>'checkbox','class'=>'checkbox_lote','label'=>'','value'=>$publicacao['Publicacao']['id']));
							}
						}
					?>				
				</td>
				<td class="id"><?php echo $publicacao['Tecnologia']['pasta']; ?></td>
				<td><?php echo $this->Html->link($publicacao['Rpi']['numero'], array('controller'=>'rpis', 'action' => 'view', $publicacao['Rpi']['numero'])); ?></td>
				<td><?php echo $despachos[$publicacao['Publicacao']['codigo_despacho']]; ?></td>
				<td>
					<?php 
						if(isset($publicacao['Tecnologia']['id']))
						{
							echo $this->Html->link($publicacao['Tecnologia']['num_pedido'], array('controller'=>'tecnologias', 'action' => 'view', $publicacao['Tecnologia']['id'])); 
						}else{
							echo $publicacao['Publicacao']['numero_processo_rpi'];
						}
					?>
				</td>
				<td>
					<?php 
						if(isset($publicacao['Tecnologia']['id'])){
							if($publicacao['Publicacao']['status_providencia_id'] == 1){
								echo '-';
							}
							if($publicacao['Publicacao']['status_providencia_id'] == 2 || $publicacao['Tecnologia']['num_pedido']==''){
								echo 'Pendente';
							}
							if($publicacao['Publicacao']['status_providencia_id'] == 3){
								echo 'Cumprida';
							} 
						}
					?>		
				</td>
				<td>
					<?php 
						if($publicacao['Publicacao']['status_providencia_id']==2){
							echo $time->format('d/m/Y', $publicacao['Publicacao']['prazo']);
						}
					?>
				</td>
				<td>
					<?php
						foreach ($publicacao['Arquivo'] as $documento) {
							echo $this->Html->link($this->Html->image('pdf-icon.png', array('alt'=> __('Baixar documento', true), 'border' => '0', 'style'=>'width:20px;')),'../arquivos/download/'.$documento['id'],array('escape' => false, 'target'=>'_blank'));
						}
					?>
				</td>
				<td class="actions" style="text-align: left; width: 115px;">
					<?php
						if($publicacao['Publicacao']['status_providencia_id']==2 && $publicacao['Tecnologia']['num_pedido']!=''){
							echo $this->Html->link(__('Cumprir', true), array('controller'=>'publicacoes', 'action' => 'cumprir', $publicacao['Publicacao']['id']), null, sprintf(__('Tem certeza que deseja marcar este despacho como cumprido?', true), $publicacao['Publicacao']['id']));
						}
					?>
				</td>
			</tr>
		<?php 
		endforeach; 
		?>
	</table>
	<button id="cumprir_lote">Cumprir em Lote</button>
</div>