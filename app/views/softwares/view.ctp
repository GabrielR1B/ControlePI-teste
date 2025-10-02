<style type="text/css">
	input[type='checkbox'] {
		float: none;
		vertical-align: bottom;
		margin-bottom: 5px;
	}
</style>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(('Editar Software'), array('action' => 'edit', $software['Software']['id'])); ?> </li>
		<li><?php echo $this->Html->link(('Deletar Software'), array('action' => 'delete', $software['Software']['id']), null, sprintf(('Você tem certeza de que deseja excluir o software em questão?'))); ?> </li>
		<li><?php echo $this->Html->link(('Listar Softwares'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(('Novo Software'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Buscar Software', true), array('action' => 'search')); ?></li>
	</ul>
</div>

<div class="softwares view">
<h2><?php  __('Software');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Titulo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $software['Software']['titulo']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Pasta'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $software['Software']['pasta']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Pasta Jurídico'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $software['Software']['pasta_juridico']; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Num Pedido'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $software['Software']['num_pedido']; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Data'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $time->format('d/m/Y', $software['Software']['data']); ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Número do Processo SEI'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $software['Software']['num_processo_sei']; ?>
			&nbsp;
		</dd>

		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status da Transferência'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<input type="checkbox" onclick="return false;" <?php if($software['Software']['st_ofertada']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Ofertada</span>
			<input type="checkbox" onclick="return false;" <?php if($software['Software']['st_em_negociacao']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Em Negociação</span>
			<input type="checkbox" onclick="return false;" <?php if($software['Software']['st_licenciada']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Licenciada/Transferida</span>
			<input type="checkbox" onclick="return false;" <?php if($software['Software']['st_parceria']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Parceria</span>
			<input type="checkbox" onclick="return false;" <?php if($software['Software']['st_contrato_rescindido']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Contrato Rescindido</span>
			<input type="checkbox" onclick="return false;" <?php if($software['Software']['st_vitrine_tecnologica']){ echo 'checked'; } ?>>
			<span style="margin-right: 15px;">Vitrine Tecnológica</span>
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Funcionalidade'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $software['Software']['funcionalidade']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Criadores'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $software['Software']['criadores']; ?>
			&nbsp;
		</dd>
		<?php if($software['Titular']){ ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Contrato de Cotitularidade'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $software['Software']['contrato_cotitularidade']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Justificativa Cotitularidade'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $software['Software']['justificativa_cotitularidade']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($software['Status']['nome'], array('controller' => 'status', 'action' => 'view', $software['Status']['id'])); ?>
			&nbsp;
		</dd>
		<?php } ?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Observações'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $software['Software']['observacoes']; ?>
			&nbsp;
		</dd>
	</dl>
</div>

<div class="related">
	<h3><?php __('Titulares');?></h3>
	<?php if (!empty($software['Titular'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Nome'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($software['Titular'] as $titular):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $titular['nome'];?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>

<div class="related">
	<h3><?php __('Departamentos');?></h3>
	<?php if (!empty($software['Departamento'])):?>
	<table class = 'simples' cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('#'); ?></th>
		<th><?php __('Nome'); ?></th>
	</tr>
	<?php
		$j = 1;
			for($i=0; $i<count($software['Unidade']);$i++):
				$class = null;
				if ($i % 2 == 0) {
					$class = ' class="altrow"';
				}
			?>
			<tr<?php echo $class;?>>
				<td class="id"><?php echo $j++; ?></td>
				<td><?php printf("%s", $software['Unidade'][$i]['nome']); 
						if(isset($software['Departamento'][$i]['nome'])) {printf(" / %s",$software['Departamento'][$i]['nome']);}else{echo " ";} ?>
				</td>
			</tr>
	<?php endfor; ?>
	</table>
<?php endif; ?>
</div>

<div class="related">
	<h3><?php __('Inventores');?></h3>
	<?php if (!empty($software['Inventor'])):?>
	<table class="simples" cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('#'); ?></th>
		<th><?php __('Nome'); ?></th>
		<th class="actions"><?php __('');?></th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($software['Inventor'] as $inventor):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>

			<td class="id"><?php echo $j++;?></td>
			<td><?php echo $inventor['nome'];?></td>

			<td class="actions" style="width:220px">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'inventores', 'action' => 'view', $inventor['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'inventores', 'action' => 'edit', $inventor['id'])); ?>
				<?php echo $this->Html->link(__('Desassociar', true), array('action' => 'desassociarInventor', $software['Software']['id'], $inventor['id']), null, __('Tem certeza que deseja desassociar este inventor deste software?', true)); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>

<div class="related">
	<h3>Empresas</h3>
	<?php if (!empty($software['Empresa'])){?>
		<table class="simples" cellpadding="0" cellspacing="0">
		<tr>
			<th><?php __('#'); ?></th>
			<th><?php __('Nome'); ?></th>
			<th><?php __('Tipo de Vínculo'); ?></th>
		</tr>
		<?php
			$i = 0;
			$j = 1;
			foreach ($software['Empresa'] as $empresa):
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
	<?php } ?>
</div>

<h3>Arquivos</h3>
	<?php if (!empty($software['Arquivo'])):?>
	<table class="simples" cellpadding="0" cellspacing="0">
	<tr>
		<th><?php __('#'); ?></th>
		<th>Arquivo</th>
		<th class="actions"></th>
	</tr>
	<?php
		$i = 0;
		$j = 1;
		foreach ($software['Arquivo'] as $arquivo):
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
		<p style="margin-bottom:10px">Não há arquivos anexados a este software</p>
	<?php endif; ?>
