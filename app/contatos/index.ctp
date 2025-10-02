<script type="text/javascript">

jQuery.fn.dataTableExt.oApi.fnSetFilteringDelay = function ( oSettings, iDelay ) {
    var _that = this;
 
    if ( iDelay === undefined ) {
        iDelay = 250;
    }
      
    this.each( function ( i ) {
        $.fn.dataTableExt.iApiIndex = i;
        var
            $this = this,
            oTimerId = null,
            sPreviousSearch = null,
            anControl = $( 'input', _that.fnSettings().aanFeatures.f );
          
            anControl.unbind( 'keyup' ).bind( 'keyup', function() {
            var $$this = $this;
  
            if (sPreviousSearch === null || sPreviousSearch != anControl.val()) {
                window.clearTimeout(oTimerId);
                sPreviousSearch = anControl.val(); 
                oTimerId = window.setTimeout(function() {
                    $.fn.dataTableExt.iApiIndex = i;
                    _that.fnFilter( anControl.val() );
                }, iDelay);
            }
        });
          
        return this;
    } );
    return this;
};

	$(document).ready(function(){

		$('#contatos').dataTable({
			"aaSorting": [[ 1, "asc" ]],
			"bProcessing": true,
        	"bServerSide": true,
        	"sAjaxSource": "./contatos/search",
        	"bScrollInfinite": true,
			"sScrollY": "500px",
			"bPaginate": false,
			"sScrollX": "99%",
		    "fnInitComplete": function(oSettings, json) {
      			$("#contatosDiv").delay(4000).css("visibility", "visible");
    		}
		});

		$('#contatos').dataTable().fnSetFilteringDelay();
	});
</script>
<style type="text/css">
	input{
		margin: 15px;
		width: 400px;
	}

	#contatos_info{
		margin: 20px;
	}

	.dataTables_length{
		visibility:hidden;
	}
</style>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Novo Contato', true), array('action' => 'add')); ?></li>
	</ul>
</div>
<h2><?php __('Contatos');?></h2>
<div class="contatos index" style="visibility:hidden;" id="contatosDiv">
	<table id='contatos' class="simples" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th>Nome</th>
				<th>Departamento</th>
				<th>Unidade</th>
				<th>Telefones</th>
				<th>E-mail</th>
				<th>Endereço</th>
			</tr>
		</thead>
		<tbody>
		<?php
			$i = 0;
			$j = 0;
	
			foreach ($contatos as $contato):
		?>
				<tr>
					<td><?php echo $contato['Contato']['nome']; ?>&nbsp;</td>
					<td><?php echo $contato['Contato']['departamento']; ?>&nbsp;</td>
					<td><?php echo $contato['Contato']['unidade']; ?>&nbsp;</td>
					<td><?php echo $contato['Contato']['telefones']; ?>&nbsp;</td>
					<td><?php echo $contato['Contato']['email']; ?>&nbsp;</td>
					<td><?php echo $contato['Contato']['endereco']; ?>&nbsp;</td>
				</tr>
		<?php 
			endforeach; 
		?>
		</tbody>
	</table>
</div>