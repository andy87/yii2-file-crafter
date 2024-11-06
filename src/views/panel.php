<?php

use yii\{ web\View, widgets\ActiveForm };
use andy87\yii2\file_crafter\{ Crafter, components\assets\FileCrafterPanelAsset };

/**
 * @var View $this
 * @var ActiveForm $form
 * @var Crafter $generator
 */

FileCrafterPanelAsset::register($this);

?>

<div class="block__generator">

    <?= $this->render('_form', [
            'form' => $form,
            'generator' => $generator
    ] );?>

    <?= $this->render('_cache', ['generator' => $generator ] );?>

</div>

<div>
    <h3>Generate</h3>
</div>

<?= $this->render('cache/tr', ['generator' => $generator ] );?>
