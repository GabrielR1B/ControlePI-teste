<div class="inventores form">

<?php 
	echo $this->Form->create('InventorTecnologia',array('url'=>array('controller'=>'inventores_tecnologias','action'=>'edit',$inventor_tecnologia['InventorTecnologia']['inventor_id'],$inventor_tecnologia['InventorTecnologia']['tecnologia_id'])));
?>
	<fieldset>
		<legend><?php echo $inventor_tecnologia['Inventor']['nome']; ?></legend>
	<?php
		echo $this->Form->input('id',array('default'=>$inventor_tecnologia['InventorTecnologia']['id']));
		echo $this->Form->input('titulo_id',array('default'=>$inventor_tecnologia['InventorTecnologia']['titulo_id'],'empty'=>''));
		echo $this->Form->input('categoria_id',array('default'=>$inventor_tecnologia['InventorTecnologia']['categoria_id'],'empty'=>''));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
