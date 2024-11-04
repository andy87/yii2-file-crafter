<?php

use yii\web\View;
use andy87\yii2\dnk_file_crafter\Crafter;
use andy87\yii2\dnk_file_crafter\components\assets\FileCrafterAsset;

/**
 * @var View $this
 * @var Crafter $generator
 */

FileCrafterAsset::register($this);

?>

<div class="block__generator">

    <?= $this->render('_form', ['generator' => $generator ] );?>

    <?= $this->render('_cache', ['generator' => $generator ] );?>

</div>

<div>
    <h3>Generate</h3>
</div>

<?= $this->render('cache/tr', ['generator' => $generator ] );?>
