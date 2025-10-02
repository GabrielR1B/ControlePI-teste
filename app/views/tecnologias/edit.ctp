<?php
	//print_r($tecnologia);
	//exit();
?>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Patentes', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nova Patente', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Buscar Patentes', true), array('action' => 'search')); ?>
		</li>
	</ul>
</div>

<div class="tecnologias form">
<h2><?php __('Editar Patente');?></h2>

<?php echo $this->Form->create('Tecnologia', array('enctype' => 'multipart/form-data') );?>

	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('titulo');
		echo $this->Form->input('num_pedido');
		echo $this->Form->input('pasta');
		echo $this->Form->input('pasta_juridico');
		echo $this->Form->input('resumo');

		echo '<div class="input"><label>Número de Reivindicações</label>';
		echo $this->Form->text('num_reivindicacoes', array('type'=>'number'));
		echo '</div>';
		
		echo $this->Form->input('reivindicacoes', array('label'=>'Quadro Reivindicatório'));
		echo $this->Form->input('data', array('separator' => ' . ', 'dateFormat' => 'DMY', 'minYear' => date('Y') - 70, 'maxYear' => date('Y') + 2 ));
		echo $this->Form->input('prioridade_interna_id', array('empty' => '', 'id'=>'prioridade_interna_id', 'label' => 'Prioridade Interna','rows'=>'1'));
		echo $this->Form->input('certificado_adicao_id', array('empty' => '', 'id'=>'certificado_adicao_id', 'label' => 'Certificado de Adição','rows'=>'1'));
		echo $this->Form->input('pais_id');
		echo $this->Form->input('natureza_id',array('label'=>'Natureza'));
		echo $this->Form->input('acompanhamento');
		echo $this->Form->input('redator_id', array('label' => 'Redator','empty'=>''));
		echo $this->Form->input('area_id');
		echo $this->Form->input('num_processo_sei', array('label'=>'Número do Processo SEI'));
		echo $this->Form->input('tem_sisgen',array('empty' => '','label'=>'Acesso ao PG/CTA?','options'=> array('0'=>'Não','1'=>'Sim')));
		echo $this->Form->input('num_sisgen',array('div'=>array('style'=>'display:none;'),'label' => 'Número de cadastro no SisGen'));
		echo $this->Form->input('andamento_id');
		echo $this->Form->input('status_id', array('label'=>'Status PI'));
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

		echo '<label>Status da Transferência</label>';
		echo $this->Form->input('st_ofertada',array('label'=>'Ofertada'));
		echo $this->Form->input('st_em_negociacao',array('label'=>'Em Negociação'));
		echo $this->Form->input('st_licenciada',array('label'=>'Licenciada/Transferida'));
		echo $this->Form->input('st_parceria',array('label'=>'Parceria'));
		echo $this->Form->input('st_contrato_rescindido',array('label'=>'Contrato Rescindido'));
		echo $this->Form->input('st_vitrine_tecnologica',array('label'=>'Vitrine Tecnológica'));
		echo $this->Form->input('observacoes_transferencia',array('label'=>'Observações da Transferência'));
	?>

	<br><br><br><strong><label>Titulares</label></strong>
	<div id="lista_titulares">
		<ul style="width: 50%;">
		<?php if ( !empty($titulares)){ ?>
			<?php $count = count($titulares) ?>

				<?php foreach ($titulares as $titular):	?>
					<li>
						<?= $titular['nome'] .'<span id="percentual" style="margin-left:0px;"><a href="../editar_participacao/'.$titular['TecnologiasTitular']['id'].'" style="background-image: none !important; float: right; width: 160px; display: inline;">Participação: ' .  $titular['TecnologiasTitular']['percentual'] . ($titular['TecnologiasTitular']['percentual'] ? '%' : '') .'</a></span>';	?>
						<a id="titular_button" href="javascript:void(0);" name="<?php echo $titular['id']; ?>"></a>
					</li>				
				<?php endforeach; ?>
		<?php }else{ ?>
			<li>Não há titulares associados a esta tecnologia</li>
		<?php } ?>
		</ul>
	</div>
	<label for="buscar_titular">Adicionar Titular:</label>
	<input id="buscar_titular" />

	<br><br><br><strong><label>Origem</label></strong>
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
		<?php else: ?>
			<li>Não há departamentos associados a esta tecnologia</li>
		<?php endif; ?>
		</ul>
	</div>
	<label for="buscar_titular">Adicionar Departamento:</label>
	<input id="buscar_departamento" />
	
	<br><br><br><strong><label>Inventores</label></strong>
	<div id="lista_inventores">
		<ul>
		<?php if (!empty($inventores)): ?>
				<?php foreach ($inventores as $inventor):	?>
					<li>
						<?php echo $inventor['nome'] ?>
						<a href="javascript:void(0);" name="<?php echo $inventor['id']; ?>"></a>
					</li>				
				<?php endforeach; ?>
		<?php else: ?>
			<li id="sem_inventores">Não há inventores associados a esta tecnologia</li>
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
						<?php 
							echo $empresa['nome'].' - '.($empresa['EmpresasTecnologia']['tipo_relacao_id'] == '1' ? 'Ofertada' : ($empresa['EmpresasTecnologia']['tipo_relacao_id'] == '2' ? 'Licenciada' : 'Autorização de Teste')); ?>
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

	<br><br><br><strong><label>Áreas Conhecimento</label></strong>
	<div id="lista_areas_conhecimento">
		<ul>
		<?php if (!empty($tecnologia['AreaConhecimento'])): ?>
				<?php foreach ($tecnologia['AreaConhecimento'] as $area):	?>
					<li>
						<?php echo $area['codigo_nome'] ?>
						<a href="javascript:void(0);" name="<?php echo $area['id']; ?>"></a>
					</li>				
				<?php endforeach; ?>
		<?php else: ?>
			<li id="sem_inventores">Não há áreas associados a esta tecnologia</li>
		<?php endif; ?>
		</ul>
	</div>
	<label for="buscar_area_conhecimento">Adicionar Área:</label>
	<input id="buscar_area_conhecimento" />

	<strong><label id="palavraschave">Palavras-chave</label></strong>
	<div id="lista_palavraschave">
		<ul>
		<?php if (!empty($palavraschave)): ?>
				<?php foreach ($palavraschave as $palavra):	?>
					<li>
						<?php echo $palavra['palavra'] ?>
						<a href="javascript:void(0);" name="<?php echo $palavra['id']; ?>"></a>
					</li>				
				<?php endforeach; ?>
		<?php else: ?>
			<li id="sem_palavra_chave">Não há palavras-chave associadas a esta tecnologia</li>
		<?php endif; ?>
		</ul>
	</div>	
	<label for="buscar_palavrachave">Adicionar Palavra-chave:</label>
	<input id="buscar_palavrachave" />
		
	<?php echo $this->Form->end('Salvar');?>
	</fieldset>
</div>

<fieldset>
		<legend>Arquivos anexados</legend>
		<div id="lista_arquivos">
			<ul>
			<?php if (!empty($arquivos)){ ?>
				<?php foreach ($arquivos as $arquivo):	?>
					<li>
						<?php echo $this->Html->link($arquivo['nomeoriginal'], array('controller' => 'arquivos', 'action' => 'download', $arquivo['id'])); ?>
						<a class='delete_file' href="javascript:void(0);" name="<?php echo $arquivo['id']; ?>"></a>
						<?php 
							if(!empty($arquivo['tipo_documento_id'])){
								echo '&nbsp;&nbsp;&nbsp;&nbsp;' . $tipos_documentos[$arquivo['tipo_documento_id']];
							}						
						?>
					</li>
				<?php endforeach; ?>
			<?php }else{ ?>
				<li>Não há arquivos anexados a esta tecnologia</li>
			<?php } ?>
			</ul>
			<br><br><br>	
			<form class="editFileForm" id="editAddFileForm" tecnologia_id="<?php echo $this->data['Tecnologia']['id']; ?>" action="" method	="post" enctype="multipart/form-data">
					<input type="file" name="data[Tecnologia][arquivo]">
					<br><br>
					<?php echo $this->Form->input('tipo_documento_id', array('label'=>'Tipo de Documento', 'options'=>$tipos_documentos)); ?>
					<div class="submit">
						<input type="submit" value="Enviar" id="editAddFileFormSubmit">
						<?php echo $this->Html->image('general/loading.gif', array('class' => 'loading')) ?>
					</div>
			</form>			
		</div>
</fieldset>

<script>
	<?php 
		if(isset($tecnologia['PrioridadeInterna']['id'])){
			echo sprintf("prioridade_interna =  [{id:%d, num_pedido:'%s',name:'%s'}];",$tecnologia['PrioridadeInterna']['id'],$tecnologia['PrioridadeInterna']['num_pedido'],$tecnologia['PrioridadeInterna']['titulo']);
		}else{
			echo "prioridade_interna = [];";
		}

		if(isset($certificados)){
			echo "certificados_adicao = ". $certificados . ";";

		}else{
			echo "certificado_adicao = [];";
		}
		
	?>	

    $(document).ready(function () {
	    $("#prioridade_interna_id").tokenInput('/controle-pi/tecnologias/ajaxPedidos/', {
	    	hintText: "Digite o número da patente nacional",
	    	preventDuplicates: true,
	    	propertyToSearch: "num_pedido",
	    	tokenLimit: 1,
	    	prePopulate: prioridade_interna,
	    	resultsFormatter: function(item){ return "<li>" + item.num_pedido + "<p>" + item.name + "</li>" }
	    });

	    $("#certificado_adicao_id").tokenInput('/controle-pi/tecnologias/ajaxCertificados/', {
	    	hintText: "Digite o número da patente nacional",
	    	preventDuplicates: true,
	    	propertyToSearch: "num_pedido",
	    	prePopulate: certificados_adicao,
	    	resultsFormatter: function(item){ return "<li>" + item.num_pedido + "<p>" + item.name + "</li>" }
	    });

	    //Controla a exibição do input do número do SisGen
	    $("#TecnologiaTemSisgen").change(function() {
	    	ExibirNumeroSisGen(this.value);
	    });
	    ExibirNumeroSisGen($("#TecnologiaTemSisgen").val());
	});

    //Exibe/esconde o número de cadastro no SisGen da tecnologia
	function ExibirNumeroSisGen(temNumeroSisGen){
		if(temNumeroSisGen == 1){
	    	$( "#TecnologiaNumSisgen").parent().show();
	    }else{
	    	$("#TecnologiaNumSisgen").parent().hide();
	    	$("#TecnologiaNumSisgen").val('');    		
	    }
	}

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
	url: base_url + "/tecnologias/ajaxAdicionarArquivos/" + $('#editAddFileForm').attr('tecnologia_id'),
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
			$('#lista_arquivos ul').append('<li><a href="' + base_url + '/arquivos/download/' + formData.id + '" >' + formData.nomeOriginal + '</a><a name="' + formData.id + '" href="javascript:void(0);" class="delete_file"></a>'+'&nbsp;&nbsp;&nbsp;&nbsp;'+formData.tipoDocumento+'</li>');			
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
				$('#sem_inventores').hide();
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

//////////////////////////	
//    ASSOCIAR ÁREA  /////
//////////////////////////	

	function associarAreaConhecimento(nome, id ) {
		jQuery.ajax({
			url: "<?php echo $this->Html->url( array('controller'=>'tecnologias', 'action'=>'ajaxAssociarAreaConhecimento') ) ?>",
			data: "id=" + id + "&tec_id=<?php echo $tecnologia_id ?>",
			dataType: "json",
			invokedata: {
				data1: "<li>" + nome + "<a href='javascript:void(0);' name='" + id + "'></a></li>"
			},
			error: function(data){
				ajaxflash("<?php echo __('Houve um erro ao associar esta área do conhecimento. Saia do sistema e tente novamente.', true) ?>");	
			},
			success: function(data){
				if (data.sucesso) {
					item = this.invokedata.data1;
					$("#lista_areas_conhecimento ul").append( item );
				}
				$('#sem_areas_conhecimento').hide();
				ajaxflash(data.retorno);	
			}// success
		})//ajax
	}// associar

	$("#buscar_area_conhecimento").autocomplete({
		source: "<?php echo $this->Html->url( array('controller'=>'areas_conhecimento', 'action'=>'ajaxListar') ) ?>",
		minLength: 2,
		select: function( event, ui ) {
			console.log(ui.item.nome);
			associarAreaConhecimento(ui.item.nome, ui.item.id );
			$("#buscar_area_conhecimento").val('');	// zera o input
			return false; // faz com que o nome selecionado não volte para o input
		}
	});


//////////////////////////	
// DESASSOCIAR ÁREA //
//////////////////////////

	jQuery("#lista_areas_conhecimento li a").live( 'click', function(event) {

		confirma = confirm("<?php echo __('Tem certeza que deseja desassociar esta área desta tecnologia?', true) ?>");
		if (!confirma) {
			// se o usuário desistir de excluir, retorna e interrompe a funcao.
			return;
		}

		jQuery.ajax({
			url: "<?php echo $this->Html->url( array('controller'=>'tecnologias', 'action'=>'ajaxDesassociarAreaConhecimento') ) ?>",
			data: "tec_id=<?php echo $tecnologia_id ?>&id=" + $(this).attr('name'), // pega o ID q está armazenado no name attribute
			dataType: "json",
			invokedata: {
				data1: $(this) // envia este objeto q armazena o item clicado, assim posso apagar o elemento após o retorno do ajax call
			},
			error: function(data){
				ajaxflash("<?php echo __('Não foi possível desassociar esta área. Por favor recarregue a página e tente novamente.', true) ?>");
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
			data: "empresa_id=" + id + "&natureza_id=1" +"&pi_id=<?php echo $tecnologia_id ?>" + "&tipo_relacao_id=" + tipo_vinculo,
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
// ASSOCIAR TITULAR  /////
//////////////////////////	

	function associarTitular( nome, id ) {
		jQuery.ajax({
			url: "<?php echo $this->Html->url( array('controller'=>'tecnologias', 'action'=>'ajaxAssociarTitular') ) ?>",
			data: "id=" + id + "&tec_id=<?php echo $tecnologia_id ?>",
			dataType: "json",
			invokedata: {
				data1: "<li>" + nome + "<a href='javascript:void(0);' name='" + id + "'></a></li>"
			},
			error: function(data){
				ajaxflash("<?php echo __('Houve um erro ao associar este titular. Saia do sistema e tente novamente.', true) ?>");	
			},
			success: function(data){
				if (data.sucesso) {
					item = this.invokedata.data1;
					$("#lista_titulares ul").append( item );
				}
				ajaxflash(data.retorno);	
			}// success
		})//ajax
	}// associar

	$("#buscar_titular").autocomplete({
		source: "<?php echo $this->Html->url( array('controller'=>'tecnologias', 'action'=>'ajaxListarTitulares') ) ?>",
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

	jQuery("#titular_button").live('click', function(event) {

		confirma = confirm("<?php echo __('Tem certeza que deseja desassociar este titular desta tecnologia?', true) ?>");
		if (!confirma) {
			// se o usuário desistir de excluir, retorna e interrompe a funcao.
			return;
		}

		jQuery.ajax({
			url: "<?php echo $this->Html->url( array('controller'=>'tecnologias', 'action'=>'ajaxDesassociarTitular') ) ?>",
			data: "tec_id=<?php echo $tecnologia_id ?>&id=" + $(this).attr('name'), // pega o ID q está armazenado no name attribute
			dataType: "json",
			invokedata: {
				data1: $(this) // envia este objeto q armazena o item clicado, assim posso apagar o elemento após o retorno do ajax call
			},
			error: function(data){
				ajaxflash("<?php echo __('Não foi possível desassociar este titular. Por favor recarregue a página e tente novamente.', true) ?>");
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
			url: "<?php echo $this->Html->url( array('controller'=>'tecnologias', 'action'=>'ajaxAssociarDepartamento') ) ?>",
			data: "id=" + id + "&tec_id=<?php echo $tecnologia_id ?>&uni_id=" + unidade_id,
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
		source: "<?php echo $this->Html->url( array('controller'=>'tecnologias', 'action'=>'ajaxListarDepartamentos') ) ?>",
		minLength: 2,
		select: function( event, ui ) {
			associarDepartamento( ui.item.nome, ui.item.id, ui.item.unidadeId );
			$("#buscar_departamento").val('');	// zera o input
			return false; // faz com que o nome selecionado não volte para o input
		}
	});

/////////////////////////////	
// DESASSOCIAR DEPARTAMENTO//
/////////////////////////////

	jQuery("#lista_departamentos li a").live( 'click', function(event) {

		confirma = confirm("<?php echo __('Tem certeza que deseja desassociar este departamento desta tecnologia?', true) ?>");
		if (!confirma) {
			// se o usuário desistir de excluir, retorna e interrompe a funcao.
			return;
		}

		jQuery.ajax({
			url: "<?php echo $this->Html->url( array('controller'=>'tecnologias', 'action'=>'ajaxDesassociarDepartamento') ) ?>",
			data: "tec_id=<?php echo $tecnologia_id ?>&id=" + $(this).attr('name'), // pega o ID q está armazenado no name attribute
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
					$('#sem_palavra_chave').hide();
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