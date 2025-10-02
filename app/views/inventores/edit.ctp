<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Inventores', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('Adicionar Inventor', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Buscar Inventores', true), array('action' => 'search')); ?></li>
		<li><?php echo $this->Html->link(__('Excluir Inventor', true), array('action' => 'delete', $this->Form->value('Inventor.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Inventor.id'))); ?></li>
		
		<li><?php echo $this->Html->link(__('Listar inventores por núm. tecnologias', true), array('action' => 'listar')); ?></li>
		
	</ul>
</div>

<div class="inventores form">
<h2><?php __('Editar Inventor'); ?></h2>
<?php echo $this->Form->create('Inventor');?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('nome',array('label'=>__('Nome Completo',true) ));
		echo $this->Form->input('cpf',array('label'=>'CPF'));
		echo $this->Form->input('unidade');
		echo $this->Form->input('departamento');
		echo $this->Form->input('categoria');
		echo $this->Form->input('vinculo_a_epoca');
		echo $this->Form->input('telefone_profissional');
		echo $this->Form->input('telefone_residencial');
		echo $this->Form->input('celular');
		echo $this->Form->input('email_institucional');
		echo $this->Form->input('email_alternativo');
		echo $this->Form->input('contatos');
		echo $this->Form->input('observacoes');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#InventorCpf").mask("999.999.999-99");
	});
</script>