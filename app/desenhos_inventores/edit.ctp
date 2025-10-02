<div class="inventores form">

<?php 
	echo $this->Form->create('DesenhoInventor',array('url'=>array('controller'=>'desenhos_inventores','action'=>'edit',$desenho_inventor['DesenhoInventor']['inventor_id'],$desenho_inventor['DesenhoInventor']['desenho_id'])));
?>
	<fieldset>
		<legend><?php echo $desenho_inventor['Inventor']['nome']; ?></legend>
	<?php
		echo $this->Form->input('id',array('default'=>$desenho_inventor['DesenhoInventor']['id']));
		echo $this->Form->input('titulo_id',array('default'=>$desenho_inventor['DesenhoInventor']['titulo_id'],'empty'=>''));
		echo $this->Form->input('categoria_id',array('default'=>$desenho_inventor['DesenhoInventor']['categoria_id'],'empty'=>''));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
