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

    <h2>
        <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" width="28px" height="28px" viewBox="0 0 32 32" version="1.1">
            <title>alt-menu</title>
            <path d="M0 26.016q0 2.496 1.76 4.224t4.256 1.76h20q2.464 0 4.224-1.76t1.76-4.224v-20q0-2.496-1.76-4.256t-4.224-1.76h-20q-2.496 0-4.256 1.76t-1.76 4.256v20zM4 26.016v-20q0-0.832 0.576-1.408t1.44-0.608h20q0.8 0 1.408 0.608t0.576 1.408v20q0 0.832-0.576 1.408t-1.408 0.576h-20q-0.832 0-1.44-0.576t-0.576-1.408zM8 24h16v-4h-16v4zM8 18.016h16v-4h-16v4zM8 12h16v-4h-16v4z"/>
        </svg>
        Model list
    </h2>

    <?= $this->render('_list', ['generator' => $generator ] );?>

</div>

<div>
    <h3>Generate</h3>
</div>