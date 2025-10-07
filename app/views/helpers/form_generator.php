<?php
App::uses('AppHelper', 'View/Helper');

class FormGeneratorHelper extends AppHelper {
    public $helpers = ['Form'];

    public function section($titulo, $model, $idBuscar, $idLista, $idHidden) {
        ob_start(); ?>
        
        <h4><?= h($titulo) ?></h4>

        <div class="input text">
            <label for="<?= h($idBuscar) ?>">Buscar <?= h($titulo) ?></label>
            <input type="text" id="<?= h($idBuscar) ?>" />
        </div>

        <ul id="<?= h($idLista) ?>"></ul>

        <div id="<?= h($idHidden) ?>">
            <?= $this->Form->input($model . '.' . $model, ['type' => 'hidden']); ?>
        </div>

        <?php
        return ob_get_clean();
    }
}
