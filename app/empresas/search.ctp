<div class="tecnologias index">
	<h2>
		<?php 
			if($tipo_relacao_id == '1'){
				__('Adicioniar Tecnologia Licenciada');	
			}else{
				__('Adicioniar Tecnologia Ofertada');	
			}
		?>			
	</h2>
		<?php echo
			$this->Form->create('Empresa', 
				array(
					'action' => 'search'
				)
			); 
		?>
		<fieldset>
		<?php
			echo $this->Form->input('pasta', array('label' => 'Pasta', 'type' => 'text'));
			echo $this->Form->input('num_pedido', array('label' => 'Número do pedido', 'type' => 'text'));
			echo $this->Form->input('titulo', array('label' => 'Título', 'type' => 'text'));
			echo $this->Form->end(__('Buscar', true));?>
		</fieldset>
</div>