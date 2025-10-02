<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(('Deletar Software'), array('action' => 'delete', $this->Form->value('Software.id')), null, sprintf(('Você tem certeza de que deseja excluir o software em questão?'))); ?></li>
		<li><?php echo $this->Html->link(__('Listar Softwares', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('Buscar Software', true), array('action' => 'search')); ?></li>
	</ul>
</div>

<div class="softwares form">
<?php echo $this->Form->create('Software', array('enctype' => 'multipart/form-data'));?>
	<fieldset>
	<legend><?php __('Editar Software'); ?></legend>
	<?php
		echo $this->Form->input('id', array('type'=>'hidden'));
		echo $this->Form->input('titulo');
		echo $this->Form->input('pasta');
		echo $this->Form->input('pasta_juridico');
		echo $this->Form->input('num_pedido', array('label'=>'Número do pedido'));
		echo $this->Form->input('data');
		echo $this->Form->input('num_processo_sei', array('label'=>'Número do Processo SEI'));
		echo '<label>Status da Transferência</label>';
		echo $this->Form->input('st_ofertada',array('label'=>'Ofertada'));
		echo $this->Form->input('st_em_negociacao',array('label'=>'Em Negociação'));
		echo $this->Form->input('st_licenciada',array('label'=>'Licenciada/Transferida'));
		echo $this->Form->input('st_parceria',array('label'=>'Parceria'));
		echo $this->Form->input('st_contrato_rescindido',array('label'=>'Contrato Rescindido'));
		echo $this->Form->input('st_vitrine_tecnologica',array('label'=>'Vitrine Tecnológica'));
		echo $this->Form->input('observacoes_transferencia',array('label'=>'Observações da Transferência'));
		echo $this->Form->input('funcionalidade');
		echo $this->Form->input('criadores');
		echo $this->Form->input('justificativa_cotitularidade');
		echo $this->Form->input('contrato_cotitularidade', array('label'=>'Contrato de Cotitularidade'));
		echo $this->Form->input('status_id',array('label'=>'Status PI'));
		echo $this->Form->input('observacoes');
	?>

	<br><br><br>
	<strong><label>Origem</label></strong>
	<div id="lista_departamentos">
		<ul>
		<?php if (!empty($departamentos)): ?>
			<?php $count = count($departamentos) ?>

				<?php foreach ($departamentos as $departamento):	?>
					<li>
						<?php echo $unidades[$departamento['unidade_id']]." / ".$departamento['nome']; ?>
						<a href="javascript:void(0);" name="<?php echo $departamento['id']; ?>"></a>
					</li>				
				<?php endforeach; ?>
		<? else: ?>
			<li>Não há departamentos associados a este software</li>
		<?php endif; ?>
		</ul>
	</div>
	<label for="buscar_titular">Adicionar Departamento:</label>
	<input id="buscar_departamento" />

	<br><br><br>
	<strong><label>Titulares</label></strong>
	<div id="lista_titulares">
		<ul>
		<?php if ( !empty($titulares)){ ?>
			<?php $count = count($titulares) ?>

				<?php foreach ($titulares as $titular):	?>
					<li class="titular">
						<?php echo $titular['nome'] ?>
						<a href="javascript:void(0);" name="<?php echo $titular['id']; ?>"></a>
					</li>				
				<?php endforeach; ?>
		<?php }else{ ?>
			<li>Não há titulares associados a este software</li>
		<?php } ?>
		</ul>
	</div>
	<label for="buscar_titular">Adicionar Titular:</label>
	<input id="buscar_titular" />

	<br><br><br>
	<strong><label>Inventores</label></strong>
	<div id="lista_inventores">
		<ul>
		<?php if (!empty($inventores)): ?>
			<?php $count = count($inventores) ?>

				<?php foreach ($inventores as $inventor):	?>
					<li>
						<?php echo $inventor['nome'] ?>
						<a href="javascript:void(0);" name="<?php echo $inventor['id']; ?>"></a>
					</li>				
				<?php endforeach; ?>
		<? else: ?>
			<li>Não há inventores associados a este software</li>
		<?php endif; ?>
		</ul>
	</div>
	<label for="buscar_inventor">Adicionar Inventor:</label>
	<input id="buscar_inventor" />

	<br><br><br>
	<strong><label>Empresas</label></strong>
	<div id="lista_empresas">
		<ul>
		<?php if (!empty($empresas)): ?>
				<?php foreach ($empresas as $empresa):	?>
					<li>
						<?php echo $empresa['nome'].' - '.($empresa['EmpresasTecnologia']['tipo_relacao_id'] == '1' ? 'Ofertada' : ($empresa['EmpresasTecnologia']['tipo_relacao_id'] == '2' ? 'Licenciada' : 'Autorização de Teste')); ?>
						<a href="javascript:void(0);" name="<?php echo $empresa['EmpresasTecnologia']['id']; ?>"></a>
					</li>				
				<?php endforeach; ?>
		<?php else: ?>
			<li id="sem_empresas">Não há empresas associadas a esta tecnologia</li>
		<?php endif; ?>
		</ul>
	</div>
	<label for="buscar_empresa">Adicionar Empresa:</label>
	<input id="buscar_empresa" />
	<br>
	<?php echo $this->Form->end(__('Submit', true));?>
	</fieldset>
</div>

<fieldset>
		<legend>Arquivos anexados</legend>
		<div id="lista_arquivos">
			<ul>
			<?php if (!empty($arquivos)){ ?>
				<?php $count = count($arquivos) ?>
	
				<?php foreach ($arquivos as $arquivo):	?>
					<li>
						<?php echo $this->Html->link($arquivo['nomeoriginal'], array('controller' => 'arquivos', 'action' => 'download', $arquivo['id'])); ?>
						<a class='delete_file' href="javascript:void(0);" name="<?php echo $arquivo['id']; ?>"></a>
					</li>
				<?php endforeach; ?>
	
			<?php }else{ ?>
				<li>Não há arquivos anexados a este software</li>
			<?php } ?>
			</ul>
			
			<form class="editFileForm" id="editAddFileForm" tecnologia_id="<?php echo $this->data['Software']['id']; ?>" action="" method	="post" enctype="multipart/form-data">
					<input type="file" name="data[Software][arquivo]">
					<div class="submit">
						<input type="submit" value="Enviar" id="editAddFileFormSubmit">
						<?php echo $this->Html->image('general/loading.gif', array('class' => 'loading')) ?>
					</div>
			</form>
		</div>
</fieldset>

<script>
//////////////////////////	
// ASSOCIAR INVENTOR /////
//////////////////////////	

	function associarInventor( nome, id ) {
		console.log(nome,id);
		jQuery.ajax({
			url: "<?php echo $this->Html->url( array('controller'=>'softwares', 'action'=>'ajaxAssociarInventor') ) ?>",
			data: "id=" + id + "&tec_id=<?php echo $software_id ?>",
			dataType: "json",
			invokedata: {
				data1: "<li>" + nome + "<a href='javascript:void(0);' name='" + id + "'></a></li>"
			},
			error: function(data){
				ajaxflash("<?php echo __('Houve um erro ao associar este inventor. Saia do sistema e tente novamente.', true) ?>");	
			},
			success: function(data){
				if (data.sucesso) {
					item = this.invokedata.data1;
					$("#lista_inventores ul").append( item );
				}
				ajaxflash(data.retorno);	
			}// success
		})//ajax
	}// associar

	$("#buscar_inventor").autocomplete({
		source: "<?php echo $this->Html->url( array('controller'=>'softwares', 'action'=>'ajaxListarInventores') ) ?>",
		minLength: 2,
		select: function( event, ui ) {
			//console.log(ui.item.nome);
			//console.log(ui.item.id);
			associarInventor( ui.item.nome, ui.item.id );
			//$("#buscar_inventor").val('');	// zera o input
			//return false; 					// faz com que o nome selecionado não volte para o input
		}
	});


//////////////////////////	
// DESASSOCIAR INVENTOR //
//////////////////////////

	jQuery("#lista_inventores li a").live( 'click', function(event) {

		confirma = confirm("<?php echo __('Tem certeza que deseja desassociar este inventor deste software?', true) ?>");
		if (!confirma) {
			// se o usuário desistir de excluir, retorna e interrompe a funcao.
			return;
		}
		
		jQuery.ajax({
			url: "<?php echo $this->Html->url( array('controller'=>'softwares', 'action'=>'ajaxDesassociarInventor') ) ?>",
			data: "tec_id=<?php echo $software_id ?>&id=" + $(this).attr('name'), // pega o ID q está armazenado no name attribute
			dataType: "json",
			invokedata: {
				data1: $(this) // envia este objeto q armazena o item clicado, assim posso apagar o elemento após o retorno do ajax call
			},
			error: function(data){
				ajaxflash("<?php echo __('Não foi possível desassociar este inventor. Por favor recarregue a página e tente novamente.', true) ?>");
			},
			success: function(data){
				if (data.sucesso) {
					this.invokedata.data1.parent().slideUp(400, function() {$(this).remove()});
				}
				ajaxflash(data.retorno);
			}
		});
	});

//////////////////////////	
// ASSOCIAR EMPRESA /////
//////////////////////////	

	function associarEmpresa(nome, id, tipo_vinculo){
		jQuery.ajax({
			url: "<?php echo $this->Html->url( array('controller'=>'empresas', 'action'=>'ajaxAssociarEmpresa') ) ?>",
			data: "empresa_id=" + id + "&natureza_id=5" +"&pi_id=<?php echo $software_id ?>" + "&tipo_relacao_id=" + tipo_vinculo,
			dataType: "json",
			type: 'GET',
			//invokedata: {
			//	data1: "<li>" + nome + "<a href='javascript:void(0);' name='" + id + "'></a></li>"
			//},
			error: function(data){
				ajaxflash("<?php echo __('Houve um erro ao associar esta empresa. Saia do sistema e tente novamente.', true) ?>");	
			},
			success: function(data){
				if (data.sucesso) {
					item = "<li>" + nome + "<a href='javascript:void(0);' name='" + data.id + "'></a></li>";
					$("#lista_empresas ul").append( item );
				}
				$('#sem_empresas').hide();
				ajaxflash(data.retorno);	
			}// success
		})//ajax
	}// associar

	$("#buscar_empresa").autocomplete({
		source: "<?php echo $this->Html->url( array('controller'=>'empresas', 'action'=>'ajaxListarEmpresas') ) ?>",
		minLength: 2,
		select: function( event, ui ) {
			associarEmpresa( ui.item.value, ui.item.id, ui.item.tipo_vinculo);
			$("#buscar_empresa").val('');	// zera o input
			return false; 									// faz com que o nome selecionado não volte para o input
		}
	});

//////////////////////////	
// DESASSOCIAR EMPRESA //
//////////////////////////

	jQuery("#lista_empresas li a").live( 'click', function(event) {
		confirma = confirm("<?php echo __('Tem certeza que deseja desassociar esta empresa desta tecnologia?', true) ?>");
		if (!confirma) {
			// se o usuário desistir de excluir, retorna e interrompe a funcao.
			return;
		}

		jQuery.ajax({
			url: "<?php echo $this->Html->url( array('controller'=>'empresas', 'action'=>'ajaxDesassociarEmpresa') ) ?>",
			data: "empresa_tecnologia_id=" + this.name, // pega o ID q está armazenado no name attribute
			dataType: "json",
			invokedata: {
				data1: $(this) // envia este objeto q armazena o item clicado, assim posso apagar o elemento após o retorno do ajax call
			},
			error: function(data){
				ajaxflash("<?php echo __('Não foi possível desassociar este inventor. Por favor recarregue a página e tente novamente.', true) ?>");
			},
			success: function(data){
				if (data.sucesso) {
					this.invokedata.data1.parent().slideUp(400, function() {$(this).remove()});
				}
				ajaxflash(data.retorno);
			}
		});
	});
	
//////////////////////////	
//  ENVIAR ARQUIVOS  /////
//////////////////////////

function preventDoubleSubmit(action) {
	if (action == null) {
		setTimeout(
			function() {
				$('form').find('input, a').attr('disabled', 'disabled');
			}, 50);
	} else if(action == 'off') {
		$('form').find('input, a').removeAttr('disabled');
	}
}

var editAddFileFormSubmit             = $('#editAddFileFormSubmit');
var editAddFileFormSubmitOriginalVal  = editAddFileFormSubmit.val();
var editAddFileFormSubmitUploadingVal = 'Enviando';

$('#editAddFileForm').ajaxForm({
	target: '.editUsersMainImage', // ALTERAR
	url: base_url + "/softwares/ajaxAdicionarArquivos/" + $('#editAddFileForm').attr('tecnologia_id'),
	dataType: "json",
	beforeSubmit: function(formData, jqForm) {				
		jqForm.find('input[type=text]').val('Enviando').end().find('img.loading').addClass('visible');
		editAddFileFormSubmit.val(editAddFileFormSubmitUploadingVal);
		thisForm = jqForm;
		preventDoubleSubmit();
	},
	error: function() {
		preventDoubleSubmit('off');
		alert('Houve um problema ao tentar enviar o arquivo. Por favor recarregue a página e tente novamente.');
		return false;
		// editAddFileFormSubmit.val(editAddFileFormSubmitOriginalVal);
		// 
		// editUsersAddImageForm.slideUp('100', function() {
		// 	editUsersAddImageSpan.text(spanInitialText);
		// });
		// 
		// thisForm.find('p').slideUp().end().removeClass('visible');
		// 
		// preventDoubleSubmit('off');			
		// 
		// console.log(formError.responseText);
		// 
		// return false;
	},
	success: function(formData,jqForm) {
		if (formData.sucesso == 1) {
			// console.log(formData.sucesso);
			$('#lista_arquivos ul').append('<li><a href="' + base_url + '/arquivos/download/' + formData.id + '" >' + formData.nomeOriginal + '</a><a name="' + formData.id + '" href="javascript:void(0);" class="delete_file"></a></li>');			
		}; // if (formData.sucesso == 1)
		
		if (formData.sucesso == 0) {
			ajaxflash(formData.retorno);
		}
		// Reload File Input Value
		editAddFileFormSubmit.val(editAddFileFormSubmitOriginalVal);
				
		// Toggle Off Loading Animated Gif
		thisForm.find('img.loading').removeClass('visible');
		
		// Reset File Input Value
		$('input[type=file]').val('');
			
		preventDoubleSubmit('off');
		
		return false;
	}
});

//////////////////////////	
// EXCLUIR ARQUIVO      //
//////////////////////////

	jQuery("#lista_arquivos li a.delete_file").live( 'click', function(event) {

		confirma = confirm("Tem certeza que deseja excluir este arquivo permanentemente?");
		if (!confirma) {
			// se o usuário desistir de excluir, retorna e interrompe a funcao.
			return;
		}
		
		jQuery.ajax({
			url: "<?php echo $this->Html->url( array('controller'=>'arquivos', 'action'=>'ajaxExcluirArquivo') ) ?>",
			data: "tec_id=<?php echo $software_id ?>&id=" + $(this).attr('name'), // pega o ID q está armazenado no name attribute
			dataType: "json",
			invokedata: {
				data1: $(this) // envia este objeto q armazena o item clicado, assim posso apagar o elemento após o retorno do ajax call
			},
			error: function(data){
				ajaxflash("Não foi possível desassociar este arquivo. Por favor recarregue a página e tente novamente.");
			},
			success: function(data){
				if (data.sucesso) {
					this.invokedata.data1.parent().slideUp(400, function() {$(this).remove()});
				}
				ajaxflash(data.retorno);
			}
		});
		
	});

	function ajaxflash(msg) {
		$("#ajax_flash").hide();
		$("#ajax_flash").html(msg);
		$("#ajax_flash").slideDown(400);
		$("#ajax_flash").delay(2500);
		$("#ajax_flash").slideUp(400);
	}
	

//////////////////////////	
//ASSOCIAR DEPARTAMENTO //
//////////////////////////	

	function associarDepartamento( nome, id, unidade_id ) {
		jQuery.ajax({
			url: "<?php echo $this->Html->url( array('controller'=>'softwares', 'action'=>'ajaxAssociarDepartamento') ) ?>",
			data: "id=" + id + "&tec_id=<?php echo $software_id ?>&uni_id=" + unidade_id,
			dataType: "json",
			invokedata: {
				data1: "<li>" + nome + "<a href='javascript:void(0);' name='" + id + "'></a></li>"
			},
			error: function(data){
				ajaxflash("<?php echo __('Houve um erro ao associar este departamento. Saia do sistema e tente novamente.', true) ?>");	
			},
			success: function(data){
				if (data.sucesso) {
					item = this.invokedata.data1;
					$("#lista_departamentos ul").append( item );
				}
				ajaxflash(data.retorno);	
			}// success
		})//ajax
	}// associar

	$("#buscar_departamento").autocomplete({
		source: "<?php echo $this->Html->url( array('controller'=>'softwares', 'action'=>'ajaxListarDepartamentos') ) ?>",
		minLength: 2,
		select: function( event, ui ) {
			associarDepartamento( ui.item.nome, ui.item.id, ui.item.unidadeId );
			//$("#buscar_departamento").val('');	// zera o input
			//return false; // faz com que o nome selecionado não volte para o input
		}
	});

/////////////////////////////	
// DESASSOCIAR DEPARTAMENTO//
/////////////////////////////

	jQuery("#lista_departamentos li a").live( 'click', function(event) {

		confirma = confirm("<?php echo __('Tem certeza que deseja desassociar este departamento deste software?', true) ?>");
		if (!confirma) {
			// se o usuário desistir de excluir, retorna e interrompe a funcao.
			return;
		}

		jQuery.ajax({
			url: "<?php echo $this->Html->url( array('controller'=>'softwares', 'action'=>'ajaxDesassociarDepartamento') ) ?>",
			data: "tec_id=<?php echo $software_id ?>&id=" + $(this).attr('name'), // pega o ID q está armazenado no name attribute
			dataType: "json",
			invokedata: {
				data1: $(this) // envia este objeto q armazena o item clicado, assim posso apagar o elemento após o retorno do ajax call
			},
			error: function(data){
				ajaxflash("<?php echo __('Não foi possível desassociar este departamento. Por favor recarregue a página e tente novamente.', true) ?>");
			},
			success: function(data){
				if (data.sucesso) {
					this.invokedata.data1.parent().slideUp(400, function() {$(this).remove()});
				}
				ajaxflash(data.retorno);
			}
		});
	});
	
	function ajaxflash(msg) {
		$("#ajax_flash").hide();
		$("#ajax_flash").html(msg);
		$("#ajax_flash").slideDown(400);
		$("#ajax_flash").delay(2500);
		$("#ajax_flash").slideUp(400);
	}

//////////////////////////	
// ASSOCIAR TITULAR  /////
//////////////////////////	

	function associarTitular( nome, id ) {
		jQuery.ajax({
			url: "<?php echo $this->Html->url( array('controller'=>'softwares', 'action'=>'ajaxAssociarTitular') ) ?>",
			data: "id=" + id + "&tec_id=<?php echo $software_id ?>",
			dataType: "json",
			invokedata: {
				data1: "<li class='titular'>" + nome + "<a href='javascript:void(0);' name='" + id + "'></a></li>"
			},
			error: function(data){
				ajaxflash("<?php echo __('Houve um erro ao associar este titular. Saia do sistema e tente novamente.', true) ?>");	
			},
			success: function(data){
				if (data.sucesso) {
					item = this.invokedata.data1;
					$("#lista_titulares ul").append( item );
					exibirContratoCotitularidade();
				}
				ajaxflash(data.retorno);	
			}// success
		})//ajax
	}// associar

	$("#buscar_titular").autocomplete({
		source: "<?php echo $this->Html->url( array('controller'=>'softwares', 'action'=>'ajaxListarTitulares') ) ?>",
		minLength: 2,
		select: function( event, ui ) {
			associarTitular( ui.item.nome, ui.item.id );
			$("#buscar_titular").val('');	// zera o input
			return false; 									// faz com que o nome selecionado não volte para o input
		}
	});

//////////////////////////	
// DESASSOCIAR TITULAR  //
//////////////////////////

	jQuery("#lista_titulares li a").live( 'click', function(event) {

		confirma = confirm("<?php echo __('Tem certeza que deseja desassociar este titular desta software?', true) ?>");
		if (!confirma) {
			// se o usuário desistir de excluir, retorna e interrompe a funcao.
			return;
		}

		jQuery.ajax({
			url: "<?php echo $this->Html->url( array('controller'=>'softwares', 'action'=>'ajaxDesassociarTitular') ) ?>",
			data: "tec_id=<?php echo $software_id ?>&id=" + $(this).attr('name'), // pega o ID q está armazenado no name attribute
			dataType: "json",
			invokedata: {
				data1: $(this) // envia este objeto q armazena o item clicado, assim posso apagar o elemento após o retorno do ajax call
			},
			error: function(data){
				ajaxflash("<?php echo __('Não foi possível desassociar este titular. Por favor recarregue a página e tente novamente.', true) ?>");
			},
			success: function(data){
				if (data.sucesso) {
					this.invokedata.data1.parent().slideUp(400, function() {$(this).remove(); exibirContratoCotitularidade() });
				}
				ajaxflash(data.retorno);
			}
		});
	});
	
	function ajaxflash(msg) {
		$("#ajax_flash").hide();
		$("#ajax_flash").html(msg);
		$("#ajax_flash").slideDown(400);
		$("#ajax_flash").delay(2500);
		$("#ajax_flash").slideUp(400);
	}

	function exibirContratoCotitularidade(){
		if($( ".titular" ).length > 0){
			//alert('Exibir');
			$('#SoftwareJustificativaCotitularidade').parent().show();
			$('#SoftwareContratoCotitularidade').parent().show();		
		}else{
			//alert('Nao Exibir');
			$('#SoftwareJustificativaCotitularidade').parent().hide();
			$('#SoftwareContratoCotitularidade').parent().hide();
		}
	}
	
	//Mostrar ou exibir os campos de cotitularidade
	$(document).ready(function(){
		exibirContratoCotitularidade();
	});
</script>