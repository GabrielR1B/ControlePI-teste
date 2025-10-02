<?php
	//if($somente_controladas != 1){
	//	echo "Exibir todas";
	//}else{
	//	echo "Exibir somente controladas";
	//}
	//exit();
?>
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
	<table class="simples" cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo "#";    ?></th>
			<th><?php echo "Código";   ?></th>
			<th><?php echo "Titulo";   ?></th>
			<th><?php echo "Tecnologia";   ?></th>
			<th><?php echo "Status";   ?></th>
			<th><?php echo "Prazo";   ?></th>
			<th><?php echo "Documentos";   ?></th>
			<th class="actions"><?php __('Actions');?></th>
		</tr>
		<?= $this->Form->checkbox('somente_controladas', array('checked'=>$somente_controladas == 1)); ?> Exibir somente controladas
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
			<?php
				if($somente_controladas != 1 || ($somente_controladas == 1 && $publicacao['Tecnologia']['acompanhamento'] == 1)){
			?>
					<tr<?php echo $class;?>>
						<td class="id"><?php echo $item + $j++; ?></td>
						<td><?php echo $publicacao['Publicacao']['codigo_despacho']; ?></td>
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
				}
			?>
		<?php 
		endforeach; 
		?>
	</table>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#somente_controladas').change(function(){
			if($('#somente_controladas').is(":checked"))
			{
				window.location = '../../rpis/view/' + <?= $rpi['Rpi']['numero'] ?> + '?somente_controladas=true';
			}else{
				window.location = '../../rpis/view/' + <?= $rpi['Rpi']['numero'] ?>;
			}
		});
	});
</script>