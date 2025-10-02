<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Listar Patentes', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Nova Patente', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Buscar Patentes', true), array('action' => 'search')); ?></li>
	</ul>
</div>


<h2><?php __('Editar Patente Internacional'); ?></h2>
<?php 
	echo $this->Form->create('PatenteInternacional',array('id'=>'form_patente','url' => array('controller' => 'patentes_internacionais', 'action' => 'edit'))); 
?>
<fieldset>
		<div> 
			<?php echo $this->Form->input('id'); ?>
			<?php echo $this->Form->input('natureza_id',array('type'=>'hidden')); ?>
			<?php echo $this->Form->label('natureza_id'); ?>
			<b>
				<?php echo $naturezas[$this->data['PatenteInternacional']['natureza_id']];?> 		
			</b>
		</div>
		<div id="pasta"> 
			<?php echo $this->Form->input('pasta',array('id'=>'pasta')); ?> 
		</div>
		<div id="pasta_juridico"> 
			<?php echo $this->Form->input('pasta_juridico',array('id'=>'pasta_juridico')); ?> 
		</div>
		<div> 
			<?php echo $this->Form->input('num_pedido', array('label'=>'Número do Pedido')); ?> 
		</div>

		<?php if ($this->data['PatenteInternacional']['natureza_id']==1){ ?>
			<div id="num_publicacao"> 
				<?php echo $this->Form->input('num_publicacao'); ?> 
			</div>	
		<?php } ?>
		<?php if ($this->data['PatenteInternacional']['natureza_id']!=1){ ?>
			<div id="pais_id"> 
				<?php echo $this->Form->input('pais_id',array('id'=>'pais_id_input','empty'=>'','label'=>'País')); ?> 
			</div>	
		<?php } ?>
		<div id="titulo"> 
			<?php echo $this->Form->input('titulo', array('type' => 'text')); ?> 
		</div>
		<div id="data"> 
			<?php echo $this->Form->input('data', array('separator' => ' . ', 'dateFormat' => 'DMY', 'minYear' => date('Y') - 70, 'maxYear' => date('Y') + 2 )); ?> 
		</div>
		<div id="tecnologia_id"> 
			<?php echo $this->Form->input('tecnologia_id',array('label'=>'Número Pedido Nacional','rows'=>'1','id'=>'tecnologia_id_input')); ?> 
		</div>
		<?php if ($this->data['PatenteInternacional']['natureza_id']==1){ ?>
			<div id="pais_id"> 
				<?php echo $this->Form->input('num_publicacao',array('id'=>'pais_id_input','empty'=>'')); ?> 
			</div>	
		<?php } ?>
		<div id="escritorio_id"> 
			<?php echo $this->Form->input('escritorio_id',array('default'=>'1','id'=>'escritorio_id')); ?> 
		</div>
		<div id="area_id"> 
			<?php echo $this->Form->input('area_id',array('empty'=>'','id'=>'area_id')); ?> 
		</div>
		<div id="redator_id"> 
			<?php echo $this->Form->input('redator_id',array('empty'=>'','id'=>'redator_id')); ?> 
		</div>
		<div id="num_processo_sei"> 
			<?php echo $this->Form->input('num_processo_sei',array('id'=>'num_processo_sei','label'=>'Número do Processo SEI')); ?> 
		</div>
		<div id="justificativa_cotitularidade"> 
			<?php echo $this->Form->input('justificativa_cotitularidade',array('id'=>'justificativa_cotitularidade')); ?> 
		</div>
		<div id="contrato_cotitularidade"> 
			<?php echo $this->Form->input('contrato_cotitularidade',array('id'=>'contrato_cotitularidade')); ?> 
		</div>
		<div id="status_id"> 
			<?php echo $this->Form->input('status_id',array('id'=>'status_id','label'=>'Status PI')); ?> 
		</div>
		<div id="status_id"> 
			<?php echo $this->Form->input('status_transferencia_id',array('label'=>'Status da Transferência','id'=>'status_id','options'=>$status_transferencias)); ?> 
			<label>Observações do Status da Transferência</label>
			<?php echo $this->Form->input('observacoes_status_transferencia',array('label'=>'')); ?>
		</div>
		<div id="observacoes"> 
			<?php echo $this->Form->input('observacoes'); ?> 
		</div>
</fieldset>

<br><br><br><strong><label>Titulares</label></strong>
<div id="lista_titulares">
	<ul>
	<?php 
		if(!empty($titulares)){ ?>
		<?php $count = count($titulares);?>
			<?php foreach ($titulares as $titular):	?>
				<li>
					<?php echo $titular['nome'] ?>
					<a href="javascript:void(0);" name="<?php echo $titular['id']; ?>"></a>
				</li>				
			<?php endforeach; ?>
	<?php }else{ ?>
			<li>Não há titulares associados a esta tecnologia.</li>
	<?php } ?>
	</ul>
</div>
<label for="buscar_titular">Adicionar Titular:</label>
<input id="buscar_titular" />


<br><br><br><strong><label>Origem</label></strong>
<div id="lista_departamentos">
	<ul>
	<?php 
		if(!empty($departamentos)){ ?>
		<?php $count = count($departamentos);?>
			<?php foreach ($departamentos as $departamento): ?>
				<li>
					<?php echo $unidades[$departamento['unidade_id']].' / '.$departamento['nome']; ?>
					<a href="javascript:void(0);" name="<?php echo $departamento['id']; ?>"></a>
				</li>				
			<?php endforeach; ?>
	<?php }else{ ?>
			<li>Não há departamentos de origenm associados a esta tecnologia.</li>
	<?php } ?>
	</ul>
</div>
<label for="buscar_titular">Adicionar Departamento:</label>
<input id="buscar_departamento" />

<br><br><br><strong><label>Inventores</label></strong>
<div id="lista_inventores">
	<ul>
	<?php 
		if(!empty($inventores)){ ?>
		<?php $count = count($inventores);?>
			<?php foreach ($inventores as $inventor): ?>
				<li>
					<?php echo $inventor['nome']; ?>
					<a href="javascript:void(0);" name="<?php echo $inventor['id']; ?>"></a>
				</li>				
			<?php endforeach; ?>
	<?php }else{ ?>
			<li>Não há departamentos de origenm associados a esta tecnologia.</li>
	<?php } ?>
	</ul>
</div>
<label for="buscar_titular">Adicionar Inventor:</label>
<input id="buscar_inventor" />

<!--<?php
if($count_nacionais > 0){ ?>
			<li>Esta patente é vinculada a um ou mais pedidos nacionais. Os inventores desta patente são herdados dos pedidos nacionais e não podem ser editados diretamente.</li>
		<?php }else{

		}
?>-->

<br><br><br><strong><label>Empresas</label></strong>
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
<br><br><br>
<?php echo $this->Form->end(__('Submit', true));?>

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
			
			<form class="editFileForm" id="editAddFileForm" tecnologia_id="<?php echo $this->data['PatenteInternacional']['id']; ?>" action="" method	="post" enctype="multipart/form-data">
					<input type="file" name="data[PatenteInternacional][arquivo]">
					<div class="submit">
						<input type="submit" value="Enviar" id="editAddFileFormSubmit">
						<?php echo $this->Html->image('general/loading.gif', array('class' => 'loading')) ?>
					</div>
			</form>
			
		</div>
</fieldset>
<script type="text/javascript"> 

	$(document).ready(function () {

	<?php
		if(isset($populate_tecnologias)){
			echo "populate_tecnologias = ".json_encode($populate_tecnologias);
		}else{
			echo "populate_tecnologias = []";
		}
	?>

	$(document).ready(function () {

			if(populate_tecnologias.length == 0){
				tecnologias_input = $("#tecnologia_id_input").tokenInput('/controle-pi/tecnologias/ajaxPedidos/', {
	    			hintText: "Digite as palavras-chave desejadas",
	    			preventDuplicates: true,
	    			propertyToSearch: "num_pedido",
	    			resultsFormatter: function(item){ return "<li>" + item.num_pedido + "</li>" }
	    			
	    		});
			}else{
				tecnologias_input = $("#tecnologia_id_input").tokenInput('/controle-pi/tecnologias/ajaxPedidos/', {
	    			hintText: "Digite as palavras-chave desejadas",
	    			preventDuplicates: true,
	    			propertyToSearch: "num_pedido",
	    			prePopulate: populate_tecnologias,
	    			resultsFormatter: function(item){ return "<li>" + item.num_pedido + "</li>" }
	    		});
			}

	});

	    pct_field = $("#num_pct_input").tokenInput('/controle-pi/patentes_internacionais/ajaxPct/', {
	    	hintText: "Digite o número da patente nacional",
	    	preventDuplicates: true,
	    	propertyToSearch: "num_pedido",
	    	tokenLimit: 1,
	    	resultsFormatter: function(item){ return "<li>" + item.num_pedido + "<p>" + item.name + "</li>" }
	    });
	    showInputs();
	});


	function hideAllInputs() {
    	$("#pasta").hide();
    	$("#pasta_juridico").hide();
    	$("#num_pct").hide();
    	$("#titulo").hide();
    	$("#tecnologia_id").hide();
    	$("#num_publicacao").hide();
    	$("#escritorio_id").hide();
    	$("#area_id").hide();
    	$("#redator_id").hide();
    	$("#num_processo_sei").hide();
    	$("#status_id").hide();
    	$("#pais_id").hide();
    	$("#num_pedido").hide();
    	$("#observacoes").hide();
	}

	function showInputs () {
		var natureza_id = parseInt(<?php echo $this->data['PatenteInternacional']['natureza_id']; ?>);
		
		switch(natureza_id){
			case 1:
				showPctInputs();
			  	break;
			case 2:
				showFaseNacionalInputs()
			  	break;
			case 3:
				showDepositoDiretoInputs();
			  	break;
			case 4:
				showProvisionalInputs();
			  	break;
			default:
				hideAllInputs();
		}

		document.getElementById("form_patente").reset();
	}

	function showPctInputs(){
		hideAllInputs();
		$("#pasta").show();
		$("#pasta_juridico").show();
    	$("#num_pedido").show();
    	$("#titulo").show();
    	$("#tecnologia_id").show();
    	$("#num_publicacao").show();
    	$("#escritorio_id").show();
    	$("#area_id").show();
    	$("#redator_id").show();
    	$("#num_processo_sei").show();
    	$("#status_id").show();
    	$("#observacoes").show();
	}

	function showFaseNacionalInputs(){
		hideAllInputs();
    	$("#pasta").show();
    	$("#pasta_juridico").show();
    	$("#num_pct").show();
    	$("#titulo").show();
    	$("#tecnologia_id").show();
    	$("#escritorio_id").show();
    	$("#area_id").show();
    	$("#redator_id").show();
    	$("#num_processo_sei").show();
    	$("#status_id").show();
    	$("#pais_id").show();
    	$("#num_pedido").show();
    	$("#observacoes").show();

    	<?php 
    		if(!empty($pct)){ 
    	?>
    			pct = <?php echo json_encode($pct['PatenteInternacional']); ?> ;
				pct_field.tokenInput("add", {id: pct.id, name: pct.name, num_pedido: pct.num_pedido});
    	<?php
    		}
    	?>

	}

	function showDepositoDiretoInputs(){
		hideAllInputs();
		$("#pasta").show();
		$("#pasta_juridico").show();
    	$("#titulo").show();
    	$("#tecnologia_id").show();
    	$("#escritorio_id").show();
    	$("#area_id").show();
    	$("#redator_id").show();
    	$("#num_processo_sei").show();
    	$("#status_id").show();
    	$("#pais_id").show();
    	$("#num_pedido").show();
    	$("#observacoes").show();
	}

	function showProvisionalInputs(){
		hideAllInputs();
		$("#pasta").show();
		$("#pasta_juridico").show();
    	$("#titulo").show();
    	$("#tecnologia_id").show();
    	$("#escritorio_id").show();
    	$("#area_id").show();
    	$("#redator_id").show();
    	$("#num_processo_sei").show();
    	$("#status_id").show();
    	$("#pais_id").show();
    	$("#num_pedido").show();
    	$("#observacoes").show();
	}
	
	hideAllInputs();

//////////////////////////	
// ASSOCIAR TITULAR  /////
//////////////////////////	

	function associarTitular( nome, id ) {
		jQuery.ajax({
			url: "<?php echo $this->Html->url( array('controller'=>'patentes_internacionais', 'action'=>'ajaxAssociarTitular') ) ?>",
			data: "id=" + id + "&tec_id=<?php echo $patente_internacional_id ?>",
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

	jQuery("#lista_titulares li a").live( 'click', function(event) {

		confirma = confirm("<?php echo __('Tem certeza que deseja desassociar este titular desta tecnologia?', true) ?>");
		if (!confirma) {
			// se o usuário desistir de excluir, retorna e interrompe a funcao.
			return;
		}

		jQuery.ajax({
			url: "<?php echo $this->Html->url( array('controller'=>'patentes_internacionais', 'action'=>'ajaxDesassociarTitular') ) ?>",
			data: "tec_id=<?php echo $patente_internacional_id ?>&id=" + $(this).attr('name'), // pega o ID q está armazenado no name attribute
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

//////////////////////////	
//ASSOCIAR DEPARTAMENTO //
//////////////////////////	

	function associarDepartamento( nome, id, unidade_id ) {
		jQuery.ajax({
			url: "<?php echo $this->Html->url( array('controller'=>'patentes_internacionais', 'action'=>'ajaxAssociarDepartamento') ) ?>",
			data: "id=" + id + "&tec_id=<?php echo $patente_internacional_id ?>&uni_id=" + unidade_id,
			dataType: "json",
			invokedata: {
				data1: "<li>" + nome + "<a href='javascript:void(0);' name='" + id + "'></a></li>"
			},
			error: function(data){
				ajaxflash("<?php echo __('Houve um erro ao associar este departamento. Tente novamente mais tarde.', true) ?>");	
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
			url: "<?php echo $this->Html->url( array('controller'=>'patentes_internacionais', 'action'=>'ajaxDesassociarDepartamento') ) ?>",
			data: "tec_id=<?php echo $patente_internacional_id ?>&id=" + $(this).attr('name'), // pega o ID q está armazenado no name attribute
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

//////////////////////////	
// ASSOCIAR EMPRESA /////
//////////////////////////	

	function associarEmpresa(nome, id, tipo_vinculo){
		jQuery.ajax({
			url: "<?php echo $this->Html->url( array('controller'=>'empresas', 'action'=>'ajaxAssociarEmpresa') ) ?>",
			data: "empresa_id=" + id + "&natureza_id=2" +"&pi_id=<?php echo $patente_internacional_id ?>" + "&tipo_relacao_id=" + tipo_vinculo,
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

/////////////////////////////	
//    ASSOCIAR INVENTOR    //
/////////////////////////////
function associarInventor( nome, id ) {
		jQuery.ajax({
			url: "<?php echo $this->Html->url( array('controller'=>'patentes_internacionais', 'action'=>'ajaxAssociarInventor') ) ?>",
			data: "id=" + id + "&tec_id=<?php echo $patente_internacional_id ?>",
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
			url: "<?php echo $this->Html->url( array('controller'=>'patentes_internacionais', 'action'=>'ajaxDesassociarInventor') ) ?>",
			data: "tec_id=<?php echo $patente_internacional_id ?>&id=" + $(this).attr('name'), // pega o ID q está armazenado no name attribute
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
	url: base_url + "/patentes_internacionais/ajaxAdicionarArquivos/" + $('#editAddFileForm').attr('tecnologia_id'),
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
			data: "tec_id=<?php echo $patente_internacional_id ?>&id=" + $(this).attr('name'), // pega o ID q está armazenado no name attribute
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
</script>
