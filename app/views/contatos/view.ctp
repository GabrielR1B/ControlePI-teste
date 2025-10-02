<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Contatos', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Novo Contato', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Editar Contato', true), array('action' => 'edit', $contato['Contato']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Deletar Contato', true), array('action' => 'delete', $contato['Contato']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $contato['Contato']['id'])); ?> </li>
	</ul>
</div>

<div class="marcas view">
		
<h2><?php __('Contato');?></h2>

	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Nome'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contato['Contato']['nome']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Unidade'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contato['Contato']['unidade']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Departamento'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contato['Contato']['departamento']; ?>
			&nbsp;
		</dd>		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cargo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contato['Contato']['cargo']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Telefone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contato['Contato']['telefones']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('E-mail'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contato['Contato']['email']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Endereço'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $contato['Contato']['endereco']; ?>
			&nbsp;
		</dd>
	</dl>
</div>