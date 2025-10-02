<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Inventores', true), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('New Inventor', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Buscar Inventores', true), array('action' => 'search')); ?></li>
		<li><?php echo $this->Html->link(__('Listar inventores por núm. tecnologias', true), array('action' => 'listar')); ?></li>
	</ul>
</div>

<div class="inventores form">
<h2><?php __('Add Inventor');?></h2>
	
	
<?php echo $this->Form->create('Inventor');?>
	<fieldset>
	<?php
		echo $this->Form->input('nome',array('label'=>__('Nome Completo',true) ));
	?>
	<div>
		<label>CPF</label>
		<input type="text" id="InventorCPF" name="data[Inventor][cpf]">
	</div>	
	<?php
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
		$("#InventorCPF").mask("999.999.999-99");
	});
</script>