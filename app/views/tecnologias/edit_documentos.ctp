<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Tecnologias', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nova Tecnologia', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Buscar Tecnologias', true), array('action' => 'search')); ?>
		</li>
	</ul>
</div>

<div class="tecnologias form">
<h2><?php __('Editar Tecnologia');?></h2>

<?php echo $this->Form->create('Tecnologia', array('enctype' => 'multipart/form-data') );?>

	<fieldset>
	<?php
		echo $this->Form->input('termo_de_participacao');
		echo $this->Form->input('declaracao_do_inventor');
		$numtit = count($tecnologia['Titular']);
		if($numtit >= 2){
			echo $this->Form->input('declaracao_de_cotitularidade');
			echo $this->Form->input('contrato_de_cotitularidade');
		}
	
		foreach($tecnologia['Titular'] as $titular){
			if($titular['id'] == 6) {
				echo $this->Form->input('termo_de_outorga');	
			}
		}
		echo $this->Form->input('observacoes',array('label'=>'Observações'));

	?>
	
	<?php echo $this->Form->end('Salvar');?>
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
				<li>Não há arquivos anexados a esta tecnologia</li>
			<?php } ?>
			</ul>
			
			<form class="editFileForm" id="editAddFileForm" tecnologia_id="<?php echo $this->data['Tecnologia']['id']; ?>" action="" method	="post" enctype="multipart/form-data">
					<input type="file" name="data[Tecnologia][arquivo]">
					<div class="submit">
						<input type="submit" value="Enviar" id="editAddFileFormSubmit">
						<?php echo $this->Html->image('general/loading.gif', array('class' => 'loading')) ?>
					</div>
			</form>
			
		</div>
</fieldset>

<script>
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
	url: base_url + "tecnologias/ajaxAdicionarArquivos/" + $('#editAddFileForm').attr('tecnologia_id'),
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
			$('#lista_arquivos ul').append('<li><a href="' + base_url + 'arquivos/download/' + formData.id + '" >' + formData.nomeOriginal + '</a><a name="' + formData.id + '" href="javascript:void(0);" class="delete_file"></a></li>');			
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
			data: "tec_id=<?php echo $tecnologia_id ?>&id=" + $(this).attr('name'), // pega o ID q está armazenado no name attribute
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

//////////////////////////	
// ASSOCIAR INVENTOR /////
//////////////////////////	

	function associarInventor( nome, id ) {
		jQuery.ajax({
			url: "<?php echo $this->Html->url( array('controller'=>'tecnologias', 'action'=>'ajaxAssociarInventor') ) ?>",
			data: "id=" + id + "&tec_id=<?php echo $tecnologia_id ?>",
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
		source: "<?php echo $this->Html->url( array('controller'=>'tecnologias', 'action'=>'ajaxListarInventores') ) ?>",
		minLength: 2,
		select: function( event, ui ) {
			associarInventor( ui.item.nome, ui.item.id );
			$("#buscar_inventor").val('');	// zera o input
			return false; 									// faz com que o nome selecionado não volte para o input
		}
	});


//////////////////////////	
// DESASSOCIAR INVENTOR //
//////////////////////////

	jQuery("#lista_inventores li a").live( 'click', function(event) {

		confirma = confirm("<?php echo __('Tem certeza que deseja desassociar este inventor desta tecnologia?', true) ?>");
		if (!confirma) {
			// se o usuário desistir de excluir, retorna e interrompe a funcao.
			return;
		}

		jQuery.ajax({
			url: "<?php echo $this->Html->url( array('controller'=>'tecnologias', 'action'=>'ajaxDesassociarInventor') ) ?>",
			data: "tec_id=<?php echo $tecnologia_id ?>&id=" + $(this).attr('name'), // pega o ID q está armazenado no name attribute
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
	
	function ajaxflash(msg) {
		$("#ajax_flash").hide();
		$("#ajax_flash").html(msg);
		$("#ajax_flash").slideDown(400);
		$("#ajax_flash").delay(2500);
		$("#ajax_flash").slideUp(400);
	}
	
	
	////////////////////////////	
	// ASSOCIAR PALAVRA-CHAVE //
	////////////////////////////

		function associarPalavrachave( palavra, id ) {
			jQuery.ajax({
				url: "<?php echo $this->Html->url( array('controller'=>'tecnologias', 'action'=>'ajaxAssociarPalavrachave') ) ?>",
				data: "id=" + id + "&tec_id=<?php echo $tecnologia_id ?>",
				dataType: "json",
				invokedata: {
					data1: "<li>" + palavra + "<a href='javascript:void(0);' name='" + id + "'></a></li>"
				},
				error: function(data){
					ajaxflash("<?php echo __('Houve um erro ao associar esta palavra-chave. Saia do sistema e tente novamente.', true) ?>");	
				},
				success: function(data){
					if (data.sucesso) {
						item = this.invokedata.data1;
						$("#lista_palavraschave ul").append( item );
					}
					ajaxflash(data.retorno);	
				}// success
			})//ajax
		}// associar

		$("#buscar_palavrachave").autocomplete({
			source: "<?php echo $this->Html->url( array('controller'=>'tecnologias', 'action'=>'ajaxListarPalavraschave') ) ?>",
			minLength: 1,
			select: function( event, ui ) {
				associarPalavrachave( ui.item.palavra, ui.item.id );
				$("#buscar_palavrachave").val('');	// zera o input
				return false; // faz com que o nome selecionado não volte para o input
			}
		});


	///////////////////////////////	
	// DESASSOCIAR PALAVRA-CHAVE //
	///////////////////////////////

		jQuery("#lista_palavraschave li a").live( 'click', function(event) {

			confirma = confirm("<?php echo __('Tem certeza que deseja desassociar esta palavra chave desta tecnologia?', true) ?>");
			if (!confirma) {
				// se o usuário desistir de excluir, retorna e interrompe a funcao.
				return;
			}

			jQuery.ajax({
				url: "<?php echo $this->Html->url( array('controller'=>'tecnologias', 'action'=>'ajaxDesassociarPalavrachave') ) ?>",
				data: "tec_id=<?php echo $tecnologia_id ?>&id=" + $(this).attr('name'), // pega o ID q está armazenado no name attribute
				dataType: "json",
				invokedata: {
					data1: $(this) // envia este objeto q armazena o item clicado, assim posso apagar o elemento após o retorno do ajax call
				},
				error: function(data){
					ajaxflash("<?php echo __('Não foi possível desassociar esta palavra-chave. Por favor recarregue a página e tente novamente.', true) ?>");
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

</script>