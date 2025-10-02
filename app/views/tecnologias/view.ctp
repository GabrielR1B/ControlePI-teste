<?php
	//print_r($publicacoes);
	//exit();
?>
<style type="text/css">
	#tooltip {
	  white-space: nowrap;
	  overflow: hidden;
	  text-overflow: ellipsis;
	  width: 220px;
	}
	
	#tooltip:hover {
	  overflow: visible;
	}

	input[type='checkbox'] {
		float: none;
		vertical-align: bottom;
		margin-bottom: 5px;
	}
</style>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Editar Patente', true), array('action' => 'edit', $tecnologia['Tecnologia']['id'])); ?> 
		</li>
		<li><?php echo $this->Html->link(__('Excluir Patente', true), array('action' => 'delete', $tecnologia['Tecnologia']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $tecnologia['Tecnologia']['id'])); ?> </li>
		<li><?php // echo $this->Html->link(__('Documentos', true), array('action' => 'edit_documentos', $tecnologia['Tecnologia']['id'])); ?> </li>
	</ul>
</div>

<div class="tecnologias view">
		
<h3><?php __('Detalhes da Patente'); ?></h3>

	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt <?php if ($i % 2 == 0) echo $class;?>><?php __('Titulo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tecnologia['Tecnologia']['titulo'];?>
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('País'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php 
				echo $tecnologia['Pais']['nome']; 
				echo " ";
				echo "<img src= '/controle-pi/img/flags/".$tecnologia['Pais']['arquivo']."', width = '16'>";
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Num Pedido'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tecnologia['Tecnologia']['num_pedido']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Pasta'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tecnologia['Tecnologia']['pasta']; ?>
			&nbsp;
		</dd>	
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Pasta Jurídico'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tecnologia['Tecnologia']['pasta_juridico']; ?>
			&nbsp;
		</dd>	
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Data'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $time->format('d/m/Y', $tecnologia['Tecnologia']['data']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Natureza'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tecnologia['NaturezaTecnologia']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Area'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($tecnologia['Area']['nome'], array('controller' => 'areas', 'action' => 'view', $tecnologia['Area']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Número do Processo SEI'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tecnologia['Tecnologia']['num_processo_sei']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class; ?> data-toggle="tooltip" title="Hooray!"><?php __('Acesso ao PG/CTA?'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php
				$opcoesSisGen = array('' => 'Não informado', '0' =>'Não', '1' => 'Sim');
				echo $opcoesSisGen[$tecnologia['Tecnologia']['tem_sisgen']]; 
			?>
			&nbsp;
		</dd>
		<?php if($tecnologia['Tecnologia']['tem_sisgen']){ ?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Número de cadastro no SisGen'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $tecnologia['Tecnologia']['num_sisgen']; ?>
				&nbsp;
			</dd>
		<?php } ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Andamento'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($tecnologia['Andamento']['nome'], array('controller' => 'andamentos', 'action' => 'view', $tecnologia['Andamento']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Redator'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($tecnologia['Redator']['nome'], array('controller' => 'redatores', 'action' => 'view', $tecnologia['Redator']['id'])); ?>
			&nbsp;
		</dd>
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo "Termo de participação" ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php if($tecnologia['Tecnologia']['termo_de_participacao']) {
				echo "<img src= '/controle-pi/img/check-icon.png', width = '15'>";
			}else{
				echo "<img src= '/controle-pi/img/not-check-icon.png', width = '15'>";
			} 
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo "Declaração do inventor" ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php if($tecnologia['Tecnologia']['declaracao_do_inventor']) {
				echo "<img src= '/controle-pi/img/check-icon.png', width = '15'>";
			}else{
				echo "<img src= '/controle-pi/img/not-check-icon.png', width = '15'>";
			} 
			?>
			&nbsp;
		</dd>

		<?php 
			$numtit = count($tecnologia['Titular']);
			if($numtit >= 2){
		?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo "Declaração de cotitularidade" ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php if($tecnologia['Tecnologia']['declaracao_de_cotitularidade']) {
				echo "<img src= '/controle-pi/img/check-icon.png', width = '15'>";
			}else{
				echo "<img src= '/controle-pi/img/not-check-icon.png', width = '15'>";
			} 
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo "Contrato de cotitularidade" ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php if($tecnologia['Tecnologia']['contrato_de_cotitularidade']) {
				echo "<img src= '/controle-pi/img/check-icon.png', width = '15'>";
			}else{
				echo "<img src= '/controle-pi/img/not-check-icon.png', width = '15'>";
			} 
			?>
			&nbsp;
		</dd>
		<?php } ?>

		<?php 
			foreach($tecnologia['Titular'] as $titular){
				if($titular['id'] == 6) {
		?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo "Termo de outorga" ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php if($tecnologia['Tecnologia']['termo_de_outorga']) {
				echo "<img src= '/controle-pi/img/check-icon.png', width = '15'>";
			}else{
				echo "<img src= '/controle-pi/img/not-check-icon.png', width = '15'>";
			} 
			?>
			&nbsp;
		</dd>

		<?php }
			} 
		?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Resumo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tecnologia['Tecnologia']['resumo']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Número de Reivindicações'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo nl2br($tecnologia['Tecnologia']['num_reivindicacoes']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Quadro Reivindicatório'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo nl2br($tecnologia['Tecnologia']['reivindicacoes']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status PI'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tecnologia['Status']['nome']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Observações'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tecnologia['Tecnologia']['observacoes']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status da Transferência'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<input type="checkbox" onclick="return false;" <?php if($tecnologia['Tecnologia']['st_ofertada']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Ofertada</span>
			<input type="checkbox" onclick="return false;" <?php if($tecnologia['Tecnologia']['st_em_negociacao']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Em Negociação</span>
			<input type="checkbox" onclick="return false;" <?php if($tecnologia['Tecnologia']['st_licenciada']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Licenciada/Transferida</span>
			<input type="checkbox" onclick="return false;" <?php if($tecnologia['Tecnologia']['st_parceria']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Parceria</span>
			<input type="checkbox" onclick="return false;" <?php if($tecnologia['Tecnologia']['st_contrato_rescindido']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Contrato Rescindido</span>
			<input type="checkbox" onclick="return false;" <?php if($tecnologia['Tecnologia']['st_vitrine_tecnologica']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Vitrine Tecnológica</span>
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Observações da Transferência'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $tecnologia['Tecnologia']['observacoes_transferencia']; ?>
			&nbsp;
		</dd>
	</dl>
</div>

<br /><h3>Patentes Relacionadas</h3>
	<?php if ($patentes_relacionadas){?>
		<table class="simples" cellpadding="0" cellspacing="0">
		<tr>
			<th><?php __('Número'); ?></th>
			<th><?php __('Natureza'); ?></th>
			<th><?php __('País'); ?></th>
			<th><?php __('Data de Depósito'); ?></th>
		</tr>
		<?php
			$i = 0;
			$j = 1;
			foreach ($patentes_relacionadas as $patente):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td width='400'>
					<?php 
						if(isset($patente['certificado_adicao']) || isset($patente['patente_original']) || isset($patente['prioridade_interna']))
						{
							echo $this->Html->link($patente['num_pedido'], array('controller' => 'tecnologias', 'action' => 'view', $patente['id']));
						}else{
							echo $this->Html->link($patente['num_pedido'], array('controller' => 'patentes_internacionais', 'action' => 'view', $patente['id']));
						}
					?>
				</td>
				<td>
					<?php 
						if(isset($patente['certificado_adicao'])){
							echo "Certificado de Adição";
						} elseif(isset($patente['patente_original']))
						{
							echo "Patente Mãe";
						}
						elseif(isset($patente['prioridade_interna']))
						{
							if(strtotime($tecnologia['Tecnologia']['data']) < strtotime($patente['data']))
							{
								echo "Pedido Posterior";
							}else{
								echo "Prioridade Interna";
							}
						}
						else{
							echo $naturezas[$patente['natureza_id']];
						}
					?>
				</td>
				<td>
					<?php 
						if(isset($patente['pais_id'])){
							echo "<img src= '/controle-pi/img/flags/".$paises[$patente['pais_id']]['arquivo']."', width = '16'>";
							echo " ";
							echo $this->Html->link($paises[$patente['pais_id']]['nome'], array('controller' => 'paises', 'action' => 'view', $patente['pais_id']));	
						}
					?>
				</td>
				<td>
					<?php 
						echo $this->Time->format('d/m/Y',$patente['data']);
					?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php }else{ ?>
		<p style="margin-bottom:10px">Não há outras patentes relacionadas a essa tecnologia</p>
	<?php } ?>

<div class="related">
	<h3>Titulares</h3>
	<?php if (!empty($tecnologia['Titular'])){?>
		<table class="simples" cellpadding="0" cellspacing="0">
		<tr>
			<th><?php __('#'); ?></th>
			<th><?php __('Nome'); ?></th>
			<th><?php __('% de participação'); ?></th>
		</tr>
		<?php
			$i = 0;
			$j = 1;
			foreach ($tecnologia['Titular'] as $titular):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td class="id"><?php echo $j++; ?></td>
				<td><?php 
						echo $titular['nome'];   
						if($titular['id'] == $tecnologia['Tecnologia']['acompanhamento']){
							echo '<img src = "/controle-pi/img/lupa.png" width ="20" title="Responsável pelo acompanhamento do pedido" >';
						} 
					?>
				</td>
				<td><?= $titular['TecnologiasTitular']['percentual'] ?></td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php }else{ ?>
		<p style="margin-bottom:10px">Não há titulares associados a esta tecnologia</p>
	<?php } ?>

	<h3>Origem</h3>
	<?php if (!empty($tecnologia['Unidade'])):?>
		<table class="simples" cellpadding="0" cellspacing="0">
		<tr>
			<th><?php __('#'); ?></th>
			<th><?php __('Nome'); ?></th>
		</tr>
		<?php
			$j = 1;
			for($i=0; $i<count($tecnologia['Unidade']);$i++):
				$class = null;
				if ($i % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td class="id"><?php echo $j++; ?></td>
				<td><?php printf("%s", $tecnologia['Unidade'][$i]['nome']); 
						if(isset($tecnologia['Departamento'][$i]['nome'])) {printf(" / %s",$tecnologia['Departamento'][$i]['nome']);}else{echo " ";} ?></td>
			</tr>
		<?php endfor; ?>
		</table>
	<?php else: ?>
		<p style="margin-bottom:10px">Não há departamentos associados a esta tecnologia</p>
	<?php endif; ?>


	<h3>Inventores</h3>
	<?php if (!empty($tecnologia['Inventor'])):?>
		<table class="simples" cellpadding="0" cellspacing="0">
		<tr>
			<th><?php __('#'); ?></th>
			<th><?php __('Nome'); ?></th>
			<th><?php __('Categoria'); ?></th>
			<th><?php __('Vínculo à época'); ?></th>
		</tr>
		<?php
			$i = 0;
			$j = 1;
			foreach ($tecnologia['Inventor'] as $inventor):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td class="id"><?php echo $j++; ?></td>
				<td><?php echo $this->Html->link($inventor['nome'], array('controller' => 'inventores', 'action' => 'view', $inventor['id'])); ?></td>
				<td><?php echo $inventor['categoria']; ?></td>
				<td><?php echo $inventor['vinculo_a_epoca']; ?></td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php else: ?>
		<p style="margin-bottom:10px">Não há inventores associados a esta tecnologia</p>
	<?php endif; ?>

	<h3>Empresas</h3>
	<?php if (!empty($tecnologia['Empresa'])){?>
		<table class="simples" cellpadding="0" cellspacing="0">
		<tr>
			<th><?php __('#'); ?></th>
			<th><?php __('Nome'); ?></th>
			<th><?php __('Tipo de Vínculo'); ?></th>
		</tr>
		<?php
			$i = 0;
			$j = 1;
			foreach ($tecnologia['Empresa'] as $empresa):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td class="id"><?php echo $j++; ?></td>
				<td><?php echo $this->Html->link($empresa['nome'], array('controller' => 'empresas', 'action' => 'view', $empresa['id'])); ?></td>
				<td><?php echo $empresa['EmpresasTecnologia']['tipo_relacao_id'] =='1' ? 'Ofertada' : ($empresa['EmpresasTecnologia']['tipo_relacao_id'] =='2' ? 'Licenciada' : 'Autorização de Teste') ?></td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php }else{ ?>
		<p style="margin-bottom:10px">Não há empresas associados a esta tecnologia</p>
	<?php } ?>

	<h3>Áreas do Conhecimento</h3>
	<?php if (!empty($tecnologia['AreaConhecimento'])):?>
		<table class="simples" cellpadding="0" cellspacing="0">
		<tr>
			<th><?php __('#'); ?></th>
			<th><?php __('Nome'); ?></th>
		</tr>
		<?php
			$i = 0;
			$j = 1;
			foreach ($tecnologia['AreaConhecimento'] as $area):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td class="id"><?php echo $j++; ?></td>
				<td><?= $area['codigo_nome'] ?></td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php else: ?>
		<p style="margin-bottom:10px">Não há inventores associados a esta tecnologia</p>
	<?php endif; ?>

	<h3>Palavras-chave</h3>
	<?php if (!empty($tecnologia['Palavrachave'])):?>
		<table class="simples" cellpadding="0" cellspacing="0">
		<tr>
			<th><?php __('#'); ?></th>
			<th><?php __('Nome'); ?></th>
		</tr>
		<?php
			$i = 0;
			$j = 1;
			foreach ($tecnologia['Palavrachave'] as $palavra):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td class="id"><?php echo $j++; ?></td>
				<td><?php echo $this->Html->link($palavra['palavra'], array('controller' => 'palavraschave', 'action' => 'view', $palavra['id'])); ?></td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php else: ?>
		<p style="margin-bottom:10px">Não há palavras-chave associadas a esta tecnologia</p>
	<?php endif; ?>

	<h3>Arquivos</h3>
	<?php if (!empty($tecnologia['Arquivo'])):?>
	<table class="simples" cellpadding="0" cellspacing="0">
	<tr>
		<th><?php __('#'); ?></th>
		<th>Arquivo</th>
		<th>Tipo de Documento</th>
		<th class="actions"></th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($tecnologia['Arquivo'] as $arquivo):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td class="id"><?php echo $j++; ?></td>
			<td><?php echo $arquivo['nomeoriginal'];?></td>
			<td><?php 
					if(!empty($arquivo['tipo_documento_id'])){
						echo $tipos_documentos[$arquivo['tipo_documento_id']];
					}	
				?>
			</td>
			<td class="actions" style="width:220px; text-align:left">
				<?php echo $this->Html->link('Baixar', array('controller' => 'arquivos', 'action' => 'download', $arquivo['id'])); ?>
				<?php echo $this->Html->link('Excluir', array('action' => 'excluirArquivo', $tecnologia['Tecnologia']['id'], $arquivo['id']), null, "Tem certeza que deseja excluir este arquivo permanentemente?"); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	<?php else: ?>
		<p style="margin-bottom:10px">Não há arquivos anexados a esta tecnologia</p>
	<?php endif; ?>

	<h3>Publicações</h3>
	<?php if (!empty($tecnologia['Publicacao'])):?>
	<table class="simples" cellpadding="0" cellspacing="0">
	<tr>
		<th>RPI</th>
		<th>Código</th>
		<th>Descrição</th>
		<th>Documentos</th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($publicacoes as $publicacao):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $this->Html->link($publicacao['Publicacao']['num_rpi'], array('controller' => 'rpis', 'action' => 'view', $publicacao['Publicacao']['num_rpi'])); ?></td>
			<td><?php echo $publicacao['Publicacao']['codigo_despacho'];?></td>
			<td><?php echo $publicacao['Despacho']['titulo'];?></td>
			<td>
				<?php
					foreach ($publicacao['Arquivo'] as $documento) {
						echo $this->Html->link($this->Html->image('pdf-icon.png', array('alt'=> __('Baixar documento', true), 'border' => '0', 'style'=>'width:20px;')),'../arquivos/download/'.$documento['id'],array('escape' => false,'target'=>'_blank'));
					}
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	<?php else: ?>
		<p style="margin-bottom:10px">Não há arquivos anexados a esta tecnologia</p>
	<?php endif; ?>