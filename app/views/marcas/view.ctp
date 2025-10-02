<style type="text/css">
	input[type='checkbox'] {
		float: none;
		vertical-align: bottom;
		margin-bottom: 5px;
	}
</style>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Marcas', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nova Marca', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Buscar Marca', true), array('action' => 'search')); ?></li>
		<li><?php echo $this->Html->link(__('Editar Marca', true), array('action' => 'edit', $marca['Marca']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Excluir Marca', true), array('action' => 'delete', $marca['Marca']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $marca['Marca']['id'])); ?> </li>
	</ul>
</div>

<div class="marcas view">
		
<h2><?php __('Detalhes da Marca');?></h2>

	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Marca'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $marca['Marca']['nome']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Processo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $marca['Marca']['processo']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Pasta'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $marca['Marca']['pasta']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Pasta Jurídico'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $marca['Marca']['pasta_juridico']; ?>
			&nbsp;
		</dd>		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Data'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $time->format('d/m/Y', $marca['Marca']['data']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Natureza'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $marca['NaturezaMarca']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Apresentação'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $marca['Apresentacao']['apresentacao']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Classe'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $marca['Marca']['classe']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Número do Processo SEI'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $marca['Marca']['num_processo_sei']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Andamento'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $marca['Andamento']['nome']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('StatusPI'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $marca['Status']['nome']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status da Transferência'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<input type="checkbox" onclick="return false;" <?php if($marca['Marca']['st_ofertada']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Ofertada</span>
			<input type="checkbox" onclick="return false;" <?php if($marca['Marca']['st_em_negociacao']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Em Negociação</span>
			<input type="checkbox" onclick="return false;" <?php if($marca['Marca']['st_licenciada']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Licenciada/Transferida</span>
			<input type="checkbox" onclick="return false;" <?php if($marca['Marca']['st_parceria']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Parceria</span>
			<input type="checkbox" onclick="return false;" <?php if($marca['Marca']['st_contrato_rescindido']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Contrato Rescindido</span>
			<input type="checkbox" onclick="return false;" <?php if($marca['Marca']['st_vitrine_tecnologica']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Vitrine Tecnológica</span>
		</dd>
		<?php if($marca['Titular']){ ?>
			<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Contrato de Cotitularidade'); ?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>>
				<?php echo $marca['Marca']['contrato_cotitularidade']; ?>
				&nbsp;
			</dd>
		<?php } ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Requerentes'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $marca['Marca']['requerentes']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Observações'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $marca['Marca']['observacoes']; ?>
			&nbsp;
		</dd>
	</dl>
</div>


<div class="related">
	<h3>Titulares</h3>
	<?php if (!empty($marca['Titular'])){?>
		<table class="simples" cellpadding="0" cellspacing="0">
		<tr>
			<th><?php __('#'); ?></th>
			<th><?php __('Nome'); ?></th>
		</tr>
		<?php
			$i = 0;
			$j = 1;
			foreach ($marca['Titular'] as $titular):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td class="id"><?php echo $j++; ?></td>
				<td><?php 
						echo $titular['nome'];
					?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php }else{ ?>
		<p style="margin-bottom:10px">Não há titulares associados a esta marca</p>
	<?php } ?>

	<h3>Inventores</h3>
	<?php if (!empty($marca['Inventor'])):?>
		<table class="simples" cellpadding="0" cellspacing="0">
		<tr>
			<th><?php __('#'); ?></th>
			<th><?php __('Nome'); ?></th>
		</tr>
		<?php
			$i = 0;
			$j = 1;
			foreach ($marca['Inventor'] as $inventor):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td class="id"><?php echo $j++; ?></td>
				<td><?php echo $this->Html->link($inventor['nome'], array('controller' => 'inventores', 'action' => 'view', $inventor['id'])); ?></td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php else: ?>
		<p style="margin-bottom:10px">Não há inventores associados a esta marca</p>
	<?php endif; ?>

	<h3>Empresas</h3>
	<?php if (!empty($marca['Empresa'])){?>
		<table class="simples" cellpadding="0" cellspacing="0">
		<tr>
			<th><?php __('#'); ?></th>
			<th><?php __('Nome'); ?></th>
			<th><?php __('Tipo de Vínculo'); ?></th>
		</tr>
		<?php
			$i = 0;
			$j = 1;
			foreach ($marca['Empresa'] as $empresa):
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
		<p style="margin-bottom:10px">Não há empresas vinculadas a esta marca</p>
	<?php } ?>

	<h3>Arquivos</h3>
	<?php if (!empty($marca['Arquivo'])):?>
	<table class="simples" cellpadding="0" cellspacing="0">
	<tr>
		<th><?php __('#'); ?></th>
		<th>Arquivo</th>
		<th class="actions"></th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($marca['Arquivo'] as $arquivo):
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