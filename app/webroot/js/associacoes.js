
/**
 * Inicializa um campo de autocomplete para associar dados de um modelo relacionado.
 *
 * @param {string} modelName - O nome do Modelo em PascalCase (ex: 'Inventor', 'Depositante').
 * @param {string} searchInputId - O ID do campo de texto para a busca (ex: 'buscar_inventor').
 * @param {string} displayListId - O ID do <ul> ou <div> onde os itens selecionados serão exibidos.
 * @param {string} hiddenContainerId - O ID do <div> que armazenará os inputs ocultos com os IDs.
 * @param {string} autocompleteUrl - A URL completa para a action AJAX que retorna a lista de sugestões.
 */
function associacaoAutocomplete(modelName, searchInputId, displayListId, hiddenContainerId, autocompleteUrl) {

    $('#' + searchInputId).autocomplete({
        source: autocompleteUrl,
        minLength: 2,
        select: function(event, ui) {
            var itemId = ui.item.id;
            var itemNome = ui.item.nome || ui.item.value;

            // Verifica se um input oculto para este item ja existe.
            if ($('#' + modelName.toLowerCase() + '_' + itemId).length === 0) {
                adicionarItemNaLista(itemId, itemNome);
            }
            // Limpa o campo de busca independentemente de o item ter sido adicionado ou não
            $(this).val('');
            return false;
        }
    });

    // 2. Função para adicionar o item
    function adicionarItemNaLista(id, nome) {
        var itemVisual = "<li id='item_visual_" + modelName.toLowerCase() + "_" + id + "'>" + 
                         nome + 
                         " <a href='#' class='remover-item-associado' data-model='" + modelName + "' data-id='" + id + "'> (remover)</a>" +
                         "</li>";
        $('#' + displayListId).append(itemVisual);

        var inputOculto = "<input type='hidden' " +
                          "name='data[" + modelName + "][" + modelName + "][]' " +
                          "value='" + id + "' " +
                          "id='" + modelName.toLowerCase() + '_' + id + "'>";
        $('#' + hiddenContainerId).append(inputOculto);
    }

    // 3. Lógica para o botão 'remover'
    $(document).on('click', '.remover-item-associado', function(e) {
        e.preventDefault();
        
        var clickedModel = $(this).data('model');
        
        if (clickedModel === modelName) {
            var itemId = $(this).data('id');
            $('#' + modelName.toLowerCase() + '_' + itemId).remove();
            $('#item_visual_' + modelName.toLowerCase() + '_' + itemId).remove();
        }
    });
}