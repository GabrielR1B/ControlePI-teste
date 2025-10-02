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

		$('#titulares').dataTable({
			"aaSorting": [[ 1, "asc" ]],
			"bProcessing": true,
        	"bServerSide": true,
        	"sAjaxSource": "./titulares/search",
        	"bScrollInfinite": true,
			"sScrollY": "200px",
			"bPaginate": false,
			"sScrollX": "99%",
		    "fnInitComplete": function(oSettings, json) {
      			$("#titularesDiv").delay(4000).css("visibility", "visible");
    		}
		});

		$('#titulares').dataTable().fnSetFilteringDelay();
	});
</script>
<style type="text/css">
	input{
		margin: 15px;
		width: 400px;
	}

	#titulares_info{
		margin: 20px;
	}

	.dataTables_length{
		visibility:hidden;
	}

	/*.dataTables_scroll{
		height: 100px;
	}*/

	.content{
		height: 100px;
	}
</style>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Novo Titular', true), array('action' => 'add')); ?></li>
	</ul>
</div>
<h2><?php __('Titulares');?></h2>
<div class="titulares index" style="visibility:hidden;" id="titularesDiv">
	<table id='titulares' class="simples" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th>Nome</th>
			</tr>
		</thead>
		<tbody>
		<?php
			$i = 0;
			$j = 0;
	
			foreach ($titulares as $titular):
		?>
				<tr>
					<td><?php echo $titular['Titular']['nome']; ?>&nbsp;</td>
				</tr>
		<?php 
			endforeach; 
		?>
		</tbody>
	</table>
</div>