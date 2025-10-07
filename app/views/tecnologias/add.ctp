<!-- Carregando o script de associaçoes -->
<?php echo $this->Html->script('associacoes'); ?>
<div class="actions">
    <ul>
        <li><?php echo $this->Html->link(__('Listar Patentes', true), array('action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('Buscar Patentes', true), array('action' => 'search')); ?></li>
    </ul>
</div>

<div class="tecnologias form">
<h2><?php __('Adicionar Patente');?></h2>
   
<?php echo $this->Form->create('Tecnologia',array());?>
    <fieldset>
    <?php
        // Seção 1 - Dados básicos da tecnologia
        echo $this->Form->input('titulo', array('type' => 'text'));
        echo $this->Form->input('num_pedido', array('type' => 'text'));
        echo $this->Form->input('pasta', array('type' => 'text'));
        echo $this->Form->input('pasta_juridico', array('type' => 'text'));
        echo $this->Form->input('resumo');
        echo '<div class="input"><label>Número de Reivindicações</label>';
        echo $this->Form->text('num_reivindicacoes', array('type'=>'number'));
        echo '</div>';
        echo $this->Form->input('reivindicacoes',array('label'=>'Quadro Reivindicatório'));
        echo $this->Form->input('data', array('separator' => ' . ', 'dateFormat' => 'DMY', 'minYear' => date('Y') - 70, 'maxYear' => date('Y') + 2 ));
        // Seção 2 - Dados adicionais
        echo $this->Form->input('prioridade_interna_id', array('empty' => '', 'id'=>'prioridade_interna_id', 'label' => 'Prioridade Interna'));
        echo $this->Form->input('certificado_adicao_id', array('empty' => '', 'id'=>'certificado_adicao_id', 'label' => 'Certificado de Adição','rows'=>'1'));
        echo $this->Form->input('pais_id', array('empty' => '', 'label' => 'País'));
        echo $this->Form->input('naturezatecnologia_id', array('empty' => '', 'label' => 'Natureza' ));
        echo $this->Form->input('acompanhamento');
        echo $this->Form->input('redator_id', array('empty' => '', 'label' => 'Redator'));
        echo $this->Form->input('area_id', array('empty' => ''));
        echo $this->Form->input('num_processo_sei', array('label'=>'Número do Processo SEI'));
        echo $this->Form->input('tem_sisgen',array('empty' => '','label'=>'Acesso ao PG/CTA (patrimônio genético/conhecimento tradicional associado)?','options'=> array('0'=>'Não','1'=>'Sim')));
        echo $this->Form->input('num_sisgen',array('div'=>array('style'=>'display:none;'),'label' => 'Número de cadastro no SisGen'));
echo $this->Form->input('andamento_id');
        echo $this->Form->input('status_id', array('label'=>'Status PI'));
echo $this->Form->input('termo_de_participacao');
        echo $this->Form->input('declaracao_do_inventor');
echo $this->Form->input('declaracao_de_cotitularidade');
echo $this->Form->input('contrato_de_cotitularidade');
echo $this->Form->input('observacoes',array('label'=>'Observações'));
//Seção 3 - Dados de Transferencia
echo '<label>Status da Transferência</label>';
echo $this->Form->input('st_ofertada',array('label'=>'Ofertada'));
echo $this->Form->input('st_em_negociacao',array('label'=>'Em Negociação'));
echo $this->Form->input('st_licenciada',array('label'=>'Licenciada/Transferida'));
echo $this->Form->input('st_parceria',array('label'=>'Parceria'));
echo $this->Form->input('st_contrato_rescindido',array('label'=>'Contrato Rescindido'));
echo $this->Form->input('st_vitrine_tecnologica',array('label'=>'Vitrine Tecnológica'));
echo $this->Form->input('observacoes_transferencia',array('label'=>'Observações da Transferência'));

       
    ?>
        <!-- Seção 4 - Titulares,  Departamentos e Unidades -->
<hr>
<h4>Titulares</h4>
        <div class = "input text">
            <label for ="buscar_titular">Buscar Titular</label>
            <input type="text" id="buscar_titular"/>
        </div>
        <ul id="lista_titulares_selecionados">
        </ul>
        <div id="titulares_hidden_container">
            <?php
            echo $this->Form->input('Titular.Titular', array('type' => 'hidden'));
            ?>
</div>
        <h4>Inventores</h4>
        <div class="input text">
            <label for="buscar_inventor">Buscar Inventor</label>
            <input type="text" id="buscar_inventor" />
        </div>

        <ul id="lista_inventores_selecionados">
         </ul>

        <div id="inventores_hidden_container">
        <?php
        echo $this->Form->input('Inventor.Inventor', array('type' => 'hidden'));
             ?>
        </div>
<h4>Departamentos</h4>
        <div class = "input text">
            <label for ="buscar_departamento">Buscar Departamento</label>
            <input type="text" id="buscar_departamento"/>
        </div>
        <ul id="lista_departamentos_selecionados">
        </ul>
        <div id="departamentos_hidden_container">
            <?php
            echo $this->Form->input('Departamento.Departamento', array('type' => 'hidden'));
            ?>
</div>
<h4>Empresas</h4>
        <div class = "input text">
            <label for ="buscar_empresa">Buscar Empresa</label>
            <input type="text" id="buscar_empresa"/>
        </div>
        <ul id="lista_empresas_selecionados">
        </ul>
        <div id="empresas_hidden_container">
            <?php
            echo $this->Form->input('Empresa.Empresa', array('type' => 'hidden'));
            ?>
</div>
<h4>Areas de Conhecimento</h4>
        <div class = "input text">
            <label for ="buscar_area">Buscar Area</label>
            <input type="text" id="buscar_area"/>
        </div>
        <ul id="lista_areas_selecionados">
        </ul>
        <div id="areas_hidden_container">
            <?php
            echo $this->Form->input('Area.Area', array('type' => 'hidden'));
            ?>
</div>
<h4>Palavras-chave</h4>
        <div class = "input text">
            <label for ="buscar_palavra">Buscar Palavra-chave</label>
            <input type="text" id="buscar_palavra"/>
        </div>
        <ul id="lista_palavras_selecionados">
        </ul>
        <div id="palavras_hidden_container">
            <?php
            echo $this->Form->input('Palavrachave.Palavrachave', array('type' => 'hidden'));
            ?>
</div>
    </fieldset>
   
<?php echo $this->Form->end(__('Submit', true));?>
</div>
            <div class ='input text area' >

            </div>

<script type="text/javascript">
    <!--
    function showMe (it1, it2, box) {
      var vis = (box.checked) ? "block" : "none";
      document.getElementById(it1).style.display = vis;
      document.getElementById(it2).style.display = vis;
    }

    $(document).ready(function () {
        $("#prioridade_interna_id").tokenInput('/controle-pi/tecnologias/ajaxPedidos/', {
            hintText: "Digite o número da patente nacional",
            preventDuplicates: true,
            propertyToSearch: "num_pedido",
            tokenLimit: 1,
            resultsFormatter: function(item){ return "<li>" + item.num_pedido + "<p>" + item.name + "</li>" }
        });

        //Controla a exibição do input do número do SisGen
        $("#TecnologiaTemSisgen").change(function() {
            ExibirNumeroSisGen(this.value);
        });
    });
    $(document).ready(function() {
        $("#certificado_adicao_id").tokenInput('/controle-pi/tecnologias/ajaxCertificados/', {
            hintText: "Digite o número do certificado de adição",
            preventDuplicates: true,
            propertyToSearch: "num_certificado",
            tokenLimit: 1,
            resultsFormatter: function(item){ return "<li>" + item.num_certificado + "<p>" + item.titulo + "</li>" }
        });
       
        //Controla a exibição do input do número do certificado de adição
        $("#TecnologiaCertificadoAdicaoId").change(function() {
            ExibirNumeroCertificadoAdicao(this.value);
        });
    });

    function ExibirNumeroCertificadoAdicao(temCertificadoAdicao){
        if(temCertificadoAdicao == 1){
            $( "#TecnologiaCertificadoAdicaoId").parent().show();
        }else{
            $("#TecnologiaCertificadoAdicaoId").parent().hide();
            $("#TecnologiaCertificadoAdicaoId").val('');            
        }
    }
    function ExibirNumeroSisGen(temNumeroSisGen){
        if(temNumeroSisGen == 1){
            $( "#TecnologiaNumSisgen").parent().show();
        }else{
            $("#TecnologiaNumSisgen").parent().hide();
            $("#TecnologiaNumSisgen").val('');          
        }
    }
$(document).ready(function() {
        associacaoAutocomplete(
            'Titular',
            'buscar_titular',
            'lista_titulares_selecionados',
            'titular_hidden_container',
            '<?php echo $this->Html->url(["controller" => "tecnologias", "action" => "ajaxListarTitulares"]); ?>'
        );
        associacaoAutocomplete(
            'Inventor',
            'buscar_inventor',
            'lista_inventores_selecionados',
            'inventores_hidden_container',
            '<?php echo $this->Html->url(["controller" => "tecnologias", "action" => "ajaxListarInventores"]); ?>'
        );
        associacaoAutocomplete(
            'Departamento',
            'buscar_departamento',
            'lista_departamentos_selecionados',
            'departamento_hidden_container',
            '<?php echo $this->Html->url(["controller" => "tecnologias", "action" => "ajaxListarDepartamentos"]); ?>'
        );
        associacaoAutocomplete(
            'Empresa',
            'buscar_empresa',
            'lista_empresas_selecionados',
            'empresa_hidden_container',
            '<?php echo $this->Html->url(["controller" => "empresas", "action" => "ajaxListarEmpresas"]); ?>'
        );
        associacaoAutocomplete(
            'Area',
            'buscar_area',
            'lista_areas_selecionados',
            'area_hidden_container',
            '<?php echo $this->Html->url(["controller" => "areas_conhecimento", "action" => "ajaxListar"]); ?>'
        );
        associacaoAutocomplete(
			'Palavrachave',
			'buscar_palavra',
			'lista_palavras_selecionados',
			'palavra_hidden_container',
			'<?php echo $this->Html->url(["controller" => "tecnologias", "action" => "ajaxListarPalavraschave"]); ?>'
		);
});
</script>
