<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Patentes', true), array('action' => 'index')); ?> </li>
	</ul>
</div>

<?php 
	foreach ($inventores as $inventor):
		
		echo $inventor['nome'];
		echo $this->Form->create('Inventor'); 
?>
		<fieldset>
		<?php 
			echo $this->Form->input('id');
			echo $this->Form->input('categoria_id');
			echo $this->Form->input('titulo_id'); 
		?>
		</fieldset>	
	<?php endforeach; ?>
	
<?php echo $this->Form->end('Salvar'); ?>