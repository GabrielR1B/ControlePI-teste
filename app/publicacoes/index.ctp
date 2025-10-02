<?php
	//print_r($publicacoes);
	//exit();
?>
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
	});
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
			<td><br><br><?php echo $this->Form->input('exibir_arquivo_morto', array('label' => 'Exibir arquivo morto', 'type' => 'checkbox')); ?></td>
		</tr>
		<tr>
			<td><?php echo $this->Form->input('data_vencimento_inicial', array('label' => 'Data de Vencimento Inicial', 'type' => 'text')); ?></td>
			<td><?php echo $this->Form->input('data_vencimento_final', array('label' => 'Data de Vencimento Final', 'type' => 'text')); ?></td>
			<td colspan="2"><?php echo $this->Form->input('despacho_id', array('label' => 'Despacho','options'=>$despachos,'empty'=>'')); ?></td>
			<td style="height: 100%;"><br><br><?php echo $this->Form->input('somente_pendentes', array('label' => 'Somente pendentes', 'type' => 'checkbox')); ?></td>			
		</tr>
		<tr>
			<td><?php echo $this->Form->input('pasta', array('label' => 'Pasta', 'type' => 'text')); ?></td>
			<td><?php echo $this->Form->end(__('Filtrar', true));?></td>
		</tr>
	</table>
</form>
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
				<td class="id"><?php echo $publicacao['Tecnologia']['pasta']; ?></td>
				<td><?php echo $this->Html->link($publicacao['Rpi']['numero'], array('controller'=>'rpis', 'action' => 'view', $publicacao['Rpi']['numero'])); ?></td>
				<td><?php echo $despachos[$publicacao['Publicacao']['codigo_despacho']]; ?></td>
				<td><?php echo $this->Html->link($publicacao['Tecnologia']['num_pedido'], array('controller'=>'tecnologias', 'action' => 'view', $publicacao['Tecnologia']['id'])); ?></td>
				<td>
					<?php 
						if($publicacao['Publicacao']['status_providencia_id']==1){
							echo '-';
						}
						if($publicacao['Publicacao']['status_providencia_id']==2 || $publicacao['Tecnologia']['num_pedido']==''){
							echo 'Pendente';
						}
						if($publicacao['Publicacao']['status_providencia_id']==3){
							echo 'Cumprida';
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
</div>