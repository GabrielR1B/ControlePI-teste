<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar RPIs', true), array('action' => 'index')); ?></li>
	</ul>
</div>

<div class="redator index">
	<h2>RPI <?php echo $rpi['Rpi']['numero']?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt <?php if ($i % 2 == 0) echo $class;?>><?php __('Data da Publicação'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $time->format('d/m/Y', $rpi['Rpi']['data_publicacao']); ?>
		</dd>
		<dt <?php if ($i % 2 == 0) echo $class;?>><?php __('Número de Publicações'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo count($publicacoes); ?>
		</dd>
	</dl>
	<br><br>
	<table>
		<tr>
			<td style="border: 0px; width: 200px;">
					<?= $this->Form->input('status_id', array('label'=>'Status PI','options'=>$status, 'empty'=>'Todos', 'value'=>isset($status_id) ? $status_id : '')); ?>
			</td>
			<td style="border: 0px;">
					<?= $this->Form->input('acompanhamento_id', array('label'=>'Acompanhamento','options'=>$acompanhamentos, 'empty'=>'Todos', 'value'=>isset($acompanhamento_id) ? $acompanhamento_id : '')); ?>
			</td>
		</tr>
	</table>	
	<table class="simples" cellpadding="0" cellspacing="0">
		<tr>
			<th style="width:1%"><?php echo "#";    ?></th>
			<th style="width:15%"><?php echo "Despacho";   ?></th>
			<th style="width:3%"><?php echo "Pasta";   ?></th>
			<th style="width:3%"><?php echo "Tecnologia";   ?></th>
			<th style="width:20%"><?php echo "Título";   ?></th>
			<th style="width:2%"><?php echo "Acompanhamento";   ?></th>
			<th style="width:3%"><?php echo "Status";   ?></th>
			<th style="width:3%"><?php echo "Prazo";   ?></th>
			<th style="width:2%"><?php echo "Documentos";   ?></th>
			<th style="width:2%" class="actions"><?php __('Actions');?></th>
		</tr>
		<br><br><br><br>
		<h3>Publicações</h3>
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
						<td class="id"><?php echo $item + $j++; ?></td>
						<td><?php echo $despachos[$publicacao['Publicacao']['codigo_despacho']]; ?></td>
						<td><?php echo $this->Html->link($publicacao['Tecnologia']['pasta'], array('controller'=>'tecnologias', 'action' => 'view', $publicacao['Tecnologia']['id'])); ?></td>
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
						<td><?php echo $publicacao['Tecnologia']['titulo']; ?></td>
						<td><?= $publicacao['Tecnologia']['acompanhamento'] == '1' ? 'UFMG' : 'Terceiros'; ?></td>
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
								if($publicacao['Publicacao']['status_providencia_id'] == 2){
									echo $time->format('d/m/Y', $publicacao['Publicacao']['prazo']);
								}
							?>
						</td>
						<td>
							<?php
								foreach ($publicacao['Arquivo'] as $documento) {
									echo $this->Html->link($this->Html->image('pdf-icon.png', array('alt'=> __('Baixar documento', true), 'border' => '0', 'style'=>'width:20px;')),'../arquivos/	download/'.$documento['id'],array('escape' => false,'target'=>'_blank'));
								}
							?>
						</td>
						<td class="actions" style="text-align: left; width: 115px;">
							<?php
								if($publicacao['Publicacao']['status_providencia_id']==2 && $publicacao['Tecnologia']['num_pedido']!=''){
									echo $this->Html->link(__('Cumprir', true), array('controller'=>'publicacoes', 'action' => 'cumprir', $publicacao['Publicacao']['id']), null, sprintf(__('Tem 	certeza que deseja marcar este despacho como cumprido?', true), $publicacao['Publicacao']['id']));
								}
							?>
						</td>
					</tr>
		<?php 
		endforeach; 
		?>
	</table>
	<br><br>
	<div class="actions">
		<ul>
			<li><a href="#" id="btn_exportar">Exportar Resultado</a></li>
		</ul>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#status_id').change(function(){
			if($('#status_id').val())
			{
				window.location = '../../rpis/view/' + <?= $rpi['Rpi']['numero'] ?> + '?status_id=' + $('#status_id').val();
			}else{
				window.location = '../../rpis/view/' + <?= $rpi['Rpi']['numero'] ?>
			}			
		});

		$('#acompanhamento_id').change(function(){
			if($('#acompanhamento_id').val())
			{
				window.location = '../../rpis/view/' + <?= $rpi['Rpi']['numero'] ?> + '?acompanhamento_id=' + $('#acompanhamento_id').val();
			}else{
				window.location = '../../rpis/view/' + <?= $rpi['Rpi']['numero'] ?>
			}			
		});

		$('#btn_exportar').click(function (){
			$.ajax({
    			type:'POST',
    			url:"../exportar/" + <?= $rpi['Rpi']['numero'] ?> + location.search,
    			data: {
            	},
    			dataType:'json'
			}).done(function(data){
    			var $a = $("<a>");
    			$a.attr("href",data.file);
    			$("body").append($a);
    			$a.attr("download","rpi_" + <?= $rpi['Rpi']['numero'] ?> + ".xlsx");
    			$a[0].click();
    			$a.remove();
			});
		});
	});
</script>