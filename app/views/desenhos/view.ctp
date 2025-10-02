<style type="text/css">
	input[type='checkbox'] {
		float: none;
		vertical-align: bottom;
		margin-bottom: 5px;
	}
</style>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar DI', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Editar DI', true), array('action' => 'edit', $desenho['Desenho']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Deletar DI', true), array('action' => 'delete', $desenho['Desenho']['id']), null, __('Você tem certeza de que deseja excluir o desenho industrial em questão?', true)); ?> </li>
		<li><?php echo $this->Html->link(__('Novo DI', true), array('action' => 'add')); ?> </li>
	</ul>
</div>

<div class="desenhos view">
<h3><?php  __('Desenho Industrial');?></h3>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Titulo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $desenho['Desenho']['titulo']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Pasta'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $desenho['Desenho']['pasta']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Criadores'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $desenho['Desenho']['criadores']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Pasta Jurídico'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $desenho['Desenho']['pasta_juridico']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Num Pedido'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $desenho['Desenho']['num_pedido']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Data'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $desenho['Desenho']['data']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Número do Processo SEI'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $desenho['Desenho']['num_processo_sei']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Area'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($desenho['Area']['nome'], array('controller' => 'areas', 'action' => 'view', $desenho['Area']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Redator'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($desenho['Redator']['nome'], array('controller' => 'redatores', 'action' => 'view', $desenho['Redator']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Andamento'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($desenho['Andamento']['nome'], array('controller' => 'andamentos', 'action' => 'view', $desenho['Andamento']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Resumo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $desenho['Desenho']['resumo']; ?>
			&nbsp;
		</dd>
		<?php if($desenho['Titular']){ ?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Contrato de Cotitularidade'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $desenho['Desenho']['contrato_cotitularidade']; ?>
				&nbsp;
			</dd>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Justificativa Cotitularidade'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $desenho['Desenho']['justificativa_cotitularidade']; ?>
				&nbsp;
			</dd>
		<?php } ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status PI'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($desenho['Status']['nome'], array('controller' => 'status', 'action' => 'view', $desenho['Status']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status da Transferência'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<input type="checkbox" onclick="return false;" <?php if($desenho['Desenho']['st_ofertada']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Ofertada</span>
			<input type="checkbox" onclick="return false;" <?php if($desenho['Desenho']['st_em_negociacao']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Em Negociação</span>
			<input type="checkbox" onclick="return false;" <?php if($desenho['Desenho']['st_licenciada']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Licenciada/Transferida</span>
			<input type="checkbox" onclick="return false;" <?php if($desenho['Desenho']['st_parceria']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Parceria</span>
			<input type="checkbox" onclick="return false;" <?php if($desenho['Desenho']['st_contrato_rescindido']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Contrato Rescindido</span>
			<input type="checkbox" onclick="return false;" <?php if($desenho['Desenho']['st_vitrine_tecnologica']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Vitrine Tecnológica</span>
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Observações'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $desenho['Desenho']['observacoes']; ?>
			&nbsp;
		</dd>
	</dl>
</div>

<div class="related">
	<h3><?php __('Titulares');?></h3>
	<?php if (!empty($desenho['Titular'])):?>
	<table class="simples" cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('#'); ?></th>
		<th><?php __('Nome'); ?></th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($desenho['Titular'] as $titular):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td class="id"><?php echo $j++; ?></td>
			<td><?php 
					echo $titular['nome'];   
					if($titular['id'] == $desenho['Desenho']['acompanhamento']){
						echo '<img src = "/controle-pi/img/lupa.png" width ="20" title="Responsável pelo acompanhamento do pedido" >';
					} 
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>

<div class="related">
	<h3><?php __('Origem');?></h3>
	<?php if (!empty($desenho['Departamento'])):?>
	<table class="simples" cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('#'); ?></th>
		<th><?php __('Nome'); ?></th>
	</tr>
	<?php
		$j = 1;
		for ($i=0; $i<count($desenho['Unidade']); $i++):
			$class = null;
			if ($i % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td class="id"><?php echo $j++; ?></td>
			<td><?php 
				print_r($desenho['Unidade'][$i]['nome']); 
				if(isset($desenho['Departamento'][$i]['nome'])) {
					printf(" / %s",$desenho['Departamento'][$i]['nome']);
				} else{
					echo " ";
				} 
			?></td>
		</tr>
		<?php endfor; ?>
	</table>
	<?php else: ?>
		<p style="margin-bottom:10px">Não há departamentos associados a esta tecnologia</p>
	<?php endif; ?>
</div>

<div class="related">
	<h3><?php __('Inventores');?></h3>
	<?php if (!empty($desenho['Inventor'])):?>
	<table class="simples" cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('#'); ?></th>
		<th><?php __('Nome'); ?></th>
		<th class="actions"><?php __('');?></th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($desenho['Inventor'] as $inventor):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td class="id"><?php echo $j++; ?></td>
			<td><?php echo $inventor['nome'];?></td>
			<td class="actions" style="width:220px">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'inventores', 'action' => 'view', $inventor['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'desenhos_inventores', 'action' => 'edit', $inventor['id'], $desenho['Desenho']['id'])); ?>
				<?php echo $this->Html->link(__('Desassociar', true), array('action' => 'desassociarInventor', $desenho['Desenho']['id'], $inventor['id']), null, __('Tem certeza que deseja desassociar este inventor desta tecnologia?', true)); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
<br>
<h3>Empresas</h3>
<?php if (!empty($desenho['Empresa'])){?>
	<table class="simples" cellpadding="0" cellspacing="0">
	<tr>
		<th><?php __('#'); ?></th>
		<th><?php __('Nome'); ?></th>
		<th><?php __('Tipo de Vínculo'); ?></th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($desenho['Empresa'] as $empresa):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td class="id"><?php echo $j++; ?></td>
			<td><?php echo $this->Html->link($empresa['nome'], array('controller' => 'empresas', 'action' => 'view', $empresa['id'])); ?></td>
			<td><?php echo $empresa['EmpresasTecnologia']['tipo_relacao_id'] =='1' ? 'Ofertada' : ($empresa['EmpresasTecnologia']['tipo_relacao_id'] =='2' ? 'Licenciada' : 'Autorização de Teste'); ?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php }else{ ?>
	<p style="margin-bottom:10px">Não há empresas associados a esta tecnologia</p>
<?php } ?>

	<h3>Arquivos</h3>
	<?php if (!empty($desenho['Arquivo'])):?>
	<table class="simples" cellpadding="0" cellspacing="0">
	<tr>
		<th><?php __('#'); ?></th>
		<th>Arquivo</th>
		<th class="actions"></th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($desenho['Arquivo'] as $arquivo):
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