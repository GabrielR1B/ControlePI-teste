<?php
	//print_r($unidades);
	//print_r($origens);
	//exit();
?>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Patentes', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nova Patente', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Editar Patente', true), array('action' => 'edit',$patente['PatenteInternacional']['id'])); ?></li>
		<li><?php echo $this->Html->link(__('Deletar Patente', true), array('action' => 'delete',$patente['PatenteInternacional']['id'])); ?></li>
	</ul>
</div>
<div class="tecnologias view">
		
<h3><?php __('Detalhes da Patente'); ?></h3>

	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt <?php if ($i % 2 == 0) echo $class;?>><?php __('Titulo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $patente['PatenteInternacional']['titulo'];?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Natureza'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $patente['NaturezaPatenteInternacional']['nome']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Localidade'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php 
				if(isset($patente['Pais']['nome'])){
					echo "<img src= '/controle-pi/img/flags/".$patente['Pais']['arquivo']."', width = '16'>";
					echo "  ";
					echo $patente['Pais']['nome']; 					
				}
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Numero do Pedido'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php 
				echo $patente['PatenteInternacional']['num_pedido'];
			?>
			&nbsp;
		</dd>
		<?php if ($patente['PatenteInternacional']['natureza_id'] == 1){ ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Numero de Publicação'); ?></dt>
		<dd <?php if ($i++ % 2 == 0) echo $class; ?> >
			<?php 
				echo $patente['PatenteInternacional']['num_publicacao'];
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Pasta'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $patente['PatenteInternacional']['pasta']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Pasta Jurídico'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $patente['PatenteInternacional']['pasta_juridico']; ?>
			&nbsp;
		</dd>	
		<?php } ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Área'); ?></dt>
		<dd <?php if ($i++ % 2 == 0) echo $class; ?> >
			<?php 
				echo $patente['Area']['nome'];
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Redator'); ?></dt>
		<dd <?php if ($i++ % 2 == 0) echo $class; ?> >
			<?php 
				echo $patente['Redator']['nome'];
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Número do Processo SEI'); ?></dt>
		<dd <?php if ($i++ % 2 == 0) echo $class; ?> >
			<?php 
				echo $patente['PatenteInternacional']['num_processo_sei'];
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Justificativa da Cotitularidade'); ?></dt>
		<dd <?php if ($i++ % 2 == 0) echo $class; ?> >
			<?php 
				echo $patente['PatenteInternacional']['justificativa_cotitularidade'];
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Contrato de Cotitularidade'); ?></dt>
		<dd <?php if ($i++ % 2 == 0) echo $class; ?> >
			<?php 
				echo $patente['PatenteInternacional']['contrato_cotitularidade'];
			?>
			&nbsp;
		</dd>	
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Data'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php 
				if($patente['PatenteInternacional']['data']!='0000-00-00')
					echo $time->format('d/m/Y', $patente['PatenteInternacional']['data']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status PI'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $patente['Status']['nome']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status da Transferência'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $patente['StatusTransferencia']['nome']; ?>
			<br>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Observações da Transferência'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $patente['PatenteInternacional']['observacoes_status_transferencia']; ?>
			&nbsp;
			</dd>
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Pasta no Setor de Regularização');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $patente['PatenteInternacional']['numero_pasta_setor_regularizacao']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Escritório'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php 
				if($patente['PatenteInternacional']['escritorio_id'])
					echo $escritorios[$patente['PatenteInternacional']['escritorio_id']];
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Observações'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $patente['PatenteInternacional']['observacoes']; ?>
			&nbsp;
		</dd>
	</dl>
</div>

<div class="related">
	<h3>Patentes Relacionadas</h3>
	<?php if (!empty($patente['Tecnologia']) || !empty($patente['PatenteInternacional']) ) { ?>
		<table class="simples" cellpadding="0" cellspacing="0">
		<tr>
			<th width='400'><?php __('Número'); ?></th>
			<th ><?php __('Natureza'); ?></th>
			<th ><?php __('País'); ?></th>
			<th ><?php __('Data de Depósito'); ?></th>
		</tr>
		<?php
			$i = 0;
			$j = 1;

			foreach ($patente['Tecnologia'] as $patente){
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td>
					<?php
						echo $this->Html->link($patente['num_pedido'], array('controller' => 'tecnologias', 'action' => 'view', $patente['id']));
					?>
				</td>
				<td>
					<?php 
						echo $naturezas_nacionais[$patente['natureza_id']];
					?>
				</td>
				<td>
					<?php 
						if(isset($patente['titulo'])){
							echo "<img src= '/controle-pi/img/flags/".$paises[2]['arquivo']."', width = '16'>";
							echo " ";
							echo $this->Html->link($paises[2]['nome'], array('controller' => 'tecnologias', 'action' => 'index'));
						}
					?>
				</td>
				<td>
					<?php 
						if(isset($patente['data'])){
							echo $time->format('d/m/Y', $patente['data']);
						}
					?>
					&nbsp;
				</td>
			</tr>
		<?php 
			}

		foreach ($internacionais as $patente){
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td>
					<?php 
						if(strcmp($patente['PatenteInternacional']['num_pedido'],'') != 0){
							echo $this->Html->link($patente['PatenteInternacional']['num_pedido'], array('controller' => 'patentes_internacionais', 'action' => 'view', $patente['PatenteInternacional']['id']));
						}else{
							echo $this->Html->link('N/A', array('controller' => 'patentes_internacionais', 'action' => 'view', $patente['PatenteInternacional']['id']));					
						}
					?>
				</td>
				<td>
					<?php 
						echo $naturezas_internacionais[$patente['PatenteInternacional']['natureza_id']];
					?>
				</td>
				<td>
					<?php 
						if(isset($patente['PatenteInternacional']['pais_id'])){
							echo "<img src= '/controle-pi/img/flags/".$paises[$patente['PatenteInternacional']['pais_id']]['arquivo']."', width = '16'>";
							echo " ";
							echo $this->Html->link($paises[$patente['PatenteInternacional']['pais_id']]['nome'], array('controller' => 'paises', 'action' => 'view', $patente['PatenteInternacional']['pais_id']));	
						}else{
							echo "<img src= '/controle-pi/img/flags/"."Wipo.gif"."', width = '16'>";
							echo " ";
							echo $this->Html->link("PCT", array('controller' => 'paises', 'action' => 'pct'));						
						}
					?>
				</td>
				<td>
					<?php echo $time->format('d/m/Y', $patente['PatenteInternacional']['data']); ?>
				</td>
			</tr>
		<?php } ?>

		</table>
	<?php }else{ ?>
		<p style="margin-bottom:10px">Não há patentes relacionadas a essa tecnologia</p>
	<?php } ?>

	<h3>Titulares</h3>
	<?php if (!empty($titulares)){?>
		<table class="simples" cellpadding="0" cellspacing="0">
		<tr>
			<th><?php __('#'); ?></th>
			<th><?php __('Nome'); ?></th>
		</tr>
		<?php
			$i = 0;
			$j = 1;
			foreach ($titulares as $titular):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td class="id"><?php echo $j++; ?></td>
				<td><?php 
						echo $titular['titulares']['nome'];
					?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php }else{ ?>
		<p style="margin-bottom:10px">Não há titulares associados a esta tecnologia</p>
	<?php } ?>

	<h3>Origem</h3>
	<?php if (!empty($origens)){?>
		<table class="simples" cellpadding="0" cellspacing="0">
		<tr>
			<th><?php __('#'); ?></th>
			<th><?php __('Nome'); ?></th>
		</tr>
		<?php
			$i = 0;
			$j = 1;
			foreach ($origens as $departamento):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td class="id"><?php echo $j++; ?></td>
				<td><?php 
						echo $unidades[$departamento['departamentos']['unidade_id']].' / '.$departamento['departamentos']['nome'];
					?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php }else{ ?>
		<p style="margin-bottom:10px">Não há departamento associados a esta tecnologia</p>
	<?php } ?>

	<h3>Inventores</h3>
	<?php if (!empty($inventores)):?>
		<table class="simples" cellpadding="0" cellspacing="0">
		<tr>
			<th><?php __('#'); ?></th>
			<th><?php __('Nome'); ?></th>
		</tr>
		<?php
			$i = 0;
			$j = 1;

			foreach ($inventores as $inventor):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td class="id"><?php echo $j++; ?></td>
				<td><?php echo $inventor['inventores']['nome'];?></td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php else: ?>
		<p style="margin-bottom:10px">Não há inventores associados a esta tecnologia</p>
	<?php endif; ?>

	<h3>Empresas</h3>
	<?php if (!empty($empresas)) {?>
		<table class="simples" cellpadding="0" cellspacing="0">
		<tr>
			<th><?php __('#'); ?></th>
			<th><?php __('Nome'); ?></th>
			<th><?php __('Tipo de Vínculo'); ?></th>
		</tr>
		<?php
			$i = 0;
			$j = 1;
			foreach ($empresas as $empresa):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td class="id"><?php echo $j++; ?></td>
				<td><?php echo $empresa['nome']; ?></td>
				<td><?php echo $empresa['EmpresasTecnologia']['tipo_relacao_id']=='1' ? 'Ofertada' : ($empresa['EmpresasTecnologia']['tipo_relacao_id'] == '2' ? 'Licenciada' : 'Autorização de Teste'); ?></td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php }else{ ?>
		<p style="margin-bottom:10px">Não há empresas associados a esta tecnologia</p>
	<?php } ?>

	<h3>Arquivos</h3>
	<?php if (!empty($patente['Arquivo'])):?>
	<table class="simples" cellpadding="0" cellspacing="0">
	<tr>
		<th><?php __('#'); ?></th>
		<th>Arquivo</th>
		<th class="actions">Ações</th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($patente['Arquivo'] as $arquivo):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td class="id"><?php echo $j++; ?></td>
			<td><?php echo $arquivo['nomeoriginal'];?></td>
			<td class="actions" style="width:220px; text-align:left">
				<?php echo $this->Html->link('Baixar', array('controller' => 'arquivos', 'action' => 'download', $arquivo['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	<?php else: ?>
		<p style="margin-bottom:10px">Não há arquivos anexados a esta tecnologia</p>
	<?php endif; ?>


</div>



			<?php 
				/*if($tecnologia['termo_de_participacao']==1){
					echo '<img src = "/ctit/img/check-icon.png" width = 15 >'
				}else{
					if($tecnologia['termo_de_participacao']==0)echo '<img src = "/ctit/img/check-icon.png" width = 15 >'
				}
				*/
			?>