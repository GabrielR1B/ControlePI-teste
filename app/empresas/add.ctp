<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Empresas', true), array('action' => 'index')); ?></li>
	</ul>
</div>

<div class="empresas form">
<h2><?php __('Adicionar Empresa');?></h2>
	
	
<?php echo $this->Form->create('Empresa');?>
	<fieldset>
	<?php
		echo $this->Form->input('nome');
		echo $this->Form->input('area_atuacao',array('label'=>__('Área de Atuação',true) ));
		echo $this->Form->input('nome_contato',array('label'=>__('Nome do Contato',true) ));
		echo $this->Form->input('cargo');
		echo $this->Form->input('telefone');
		echo $this->Form->input('email',array('label'=>__('E-mail',true) ));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>