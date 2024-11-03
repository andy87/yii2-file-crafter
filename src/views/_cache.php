<?php

use yii\web\View;
use andy87\yii2\dnk_file_crafter\Crafter;

/**
 * @var View $this
 * @var Crafter $generator
 */

$R = $generator->panelResources;

?>

<div class="block__cache">

    <div class="b_cache--item">

        <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" width="28px" height="28px" viewBox="0 0 32 32" version="1.1">
            <title>alt-menu</title>
            <path d="M0 26.016q0 2.496 1.76 4.224t4.256 1.76h20q2.464 0 4.224-1.76t1.76-4.224v-20q0-2.496-1.76-4.256t-4.224-1.76h-20q-2.496 0-4.256 1.76t-1.76 4.256v20zM4 26.016v-20q0-0.832 0.576-1.408t1.44-0.608h20q0.8 0 1.408 0.608t0.576 1.408v20q0 0.832-0.576 1.408t-1.408 0.576h-20q-0.832 0-1.44-0.576t-0.576-1.408zM8 24h16v-4h-16v4zM8 18.016h16v-4h-16v4zM8 12h16v-4h-16v4z"/>
        </svg>

        <label class="b_cache--label __big">
            <input class="b_cache--checkbox" type="checkbox" name="check_all" value="generate" title="Checked all">

            <b>Model list</b>
        </label>
    </div>

    <?php foreach ($R->listTableInfoDto as $tableInfoDto ): ?>
        <div class="b_cache--item">
            <a class="b_cache--link" href="<?= $tableInfoDto->getUpdateHref(); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" width="28px" height="28px" viewBox="0 0 32 32" version="1.1">
                    <path d="M0 26.016v-20q0-2.496 1.76-4.256t4.256-1.76h14.688l-4.032 4h-10.656q-0.832 0-1.44 0.608t-0.576 1.408v20q0 0.832 0.576 1.408t1.44 0.576h20q0.8 0 1.408-0.576t0.576-1.408v-10.688l4-4v14.688q0 2.496-1.76 4.224t-4.224 1.76h-20q-2.496 0-4.256-1.76t-1.76-4.224zM6.016 26.016l2.112-7.84 12.256-12.192 5.728 5.568-12.32 12.288zM22.112 4.256l3.072-3.072q1.152-1.184 2.816-1.184t2.816 1.184 1.184 2.816-1.184 2.848l-2.976 2.976z"/>
                </svg>
            </a>

            <label class="b_cache--label">
                <input class="b_cache--checkbox" type="checkbox" name="generateList[<?= $tableInfoDto->tableName ?>]" value="generate" title="Generate files for <?= $tableInfoDto->tableName ?>">

                <?= $tableInfoDto->displayTablename() ?>
            </label>
        </div>
    <?php endforeach; ?>

</div>

