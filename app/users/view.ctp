<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar', true), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('New User', true), array('action' => 'add')); ?></li>
	</ul>
</div>

<div class="redator index">
	<h2><?php echo $user['User']['first_name']?></h2>

	<table class="simples" cellpadding="0" cellspacing="0" >
		<tr>
			<td><b> Setor </b></td> 
			<td><?php echo $user['Group']['name'] ?></td>
		</tr>
		<tr> </tr>
		<tr> </tr>
		<tr> </tr>
	</table>
</div>