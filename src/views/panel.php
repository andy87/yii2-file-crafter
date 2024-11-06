<?php

use andy87\yii2\file_crafter\components\Log;
use yii\web\View;
use andy87\yii2\file_crafter\Crafter;
use andy87\yii2\file_crafter\components\assets\FileCrafterPanelAsset;

/**
 * @var View $this
 * @var Crafter $generator
 */

FileCrafterPanelAsset::register($this);

?>

<div class="block__generator">

    <?= $this->render('_form', ['generator' => $generator ] );?>

    <?= $this->render('_cache', ['generator' => $generator ] );?>

</div>

<div>
    <h3>Generate</h3>
</div>

<?= $this->render('cache/tr', ['generator' => $generator ] );?>
