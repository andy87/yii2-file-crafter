<?php

use yii\web\View;
use andy87\yii2\file_crafter\{ Crafter, components\models\Schema };

/**
 * @var View $this
 * @var Crafter $generator
 */

$R = $generator->panelResources;

?>

<div class="block__cache">

    <div class="b_cache--item">

        <svg xmlns="http://www.w3.org/2000/svg" fill="#000" width="28px" height="28px" viewBox="0 0 32 32">
            <title>alt-menu</title>
            <path d="M0 26.016q0 2.496 1.76 4.224t4.256 1.76h20q2.464 0 4.224-1.76t1.76-4.224v-20q0-2.496-1.76-4.256t-4.224-1.76h-20q-2.496 0-4.256 1.76t-1.76 4.256v20zM4 26.016v-20q0-0.832 0.576-1.408t1.44-0.608h20q0.8 0 1.408 0.608t0.576 1.408v20q0 0.832-0.576 1.408t-1.408 0.576h-20q-0.832 0-1.44-0.576t-0.576-1.408zM8 24h16v-4h-16v4zM8 18.016h16v-4h-16v4zM8 12h16v-4h-16v4z"/>
        </svg>

        <label class="b_cache--label __big">
            <input class="b_cache--checkbox" type="checkbox" onchange="app.cache.checkedAll(this)" value="generate" title="Checked all">

            <b>Model list</b>
        </label>
    </div>

    <?php foreach ( $R->listSchemaDto as $schema ):
        /** @var Schema $schema */
        if ( $schema->itIs($R->schema->table_name) && empty($R->schema->errors) ) continue;
    ?>
        <div class="b_cache--item">
            <a class="b_cache--link" href="<?= $schema->getUpdateHref(); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#000" width="28px" height="28px" viewBox="0 0 32 32">
                    <path d="M0 26.016v-20q0-2.496 1.76-4.256t4.256-1.76h14.688l-4.032 4h-10.656q-0.832 0-1.44 0.608t-0.576 1.408v20q0 0.832 0.576 1.408t1.44 0.576h20q0.8 0 1.408-0.576t0.576-1.408v-10.688l4-4v14.688q0 2.496-1.76 4.224t-4.224 1.76h-20q-2.496 0-4.256-1.76t-1.76-4.224zM6.016 26.016l2.112-7.84 12.256-12.192 5.728 5.568-12.32 12.288zM22.112 4.256l3.072-3.072q1.152-1.184 2.816-1.184t2.816 1.184 1.184 2.816-1.184 2.848l-2.976 2.976z"/>
                </svg>
            </a>

            <label class="b_cache--label">
                <input class="b_cache--checkbox" type="checkbox" value="generate"
                       name="Crafter[generateList][<?= $schema->getTableName() ?>]"
                       title="Generate files for <?= $schema->getTableName() ?>"
                <?= ( $schema->isPreviewGenerate($generator->generateList) ) ? 'checked' : '' ?>>

                <?= $schema->name ?>

                <button class="b_cache--button __info" data-toggle="popover" data-content='<?= $schema->getContent(); ?>'>
                    <svg xmlns="http://www.w3.org/2000/svg" width="28px" height="28px" viewBox="0 0 32 32">
                        <g id="Complete">
                            <g id="info-square">
                                <g>
                                    <rect data-name="--Rectangle" fill="none" height="20" id="_--Rectangle" rx="2" ry="2" stroke="#0000DD" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" width="20" x="2" y="2"/>
                                    <line fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="12" x2="12" y1="12" y2="16"/>
                                    <line fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" x1="12" x2="12" y1="8" y2="8"/>
                                </g>
                            </g>
                        </g>
                    </svg>
                </button>
            </label>
            <button class="b_cache--button" onclick="app.cache.removeModel('<?=$schema->getTableName()?>')" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#FF0000" width="20px" height="20px" viewBox="0 0 32 32">
                    <path d="M0 26.016q0 2.496 1.76 4.224t4.256 1.76h20q2.464 0 4.224-1.76t1.76-4.224v-20q0-2.496-1.76-4.256t-4.224-1.76h-20q-2.496 0-4.256 1.76t-1.76 4.256v20zM4 26.016v-20q0-0.832 0.576-1.408t1.44-0.608h20q0.8 0 1.408 0.608t0.576 1.408v20q0 0.832-0.576 1.408t-1.408 0.576h-20q-0.832 0-1.44-0.576t-0.576-1.408zM8 16q0 0.832 0.576 1.44t1.44 0.576h12q0.8 0 1.408-0.576t0.576-1.44-0.576-1.408-1.408-0.576h-12q-0.832 0-1.44 0.576t-0.576 1.408z"/>
                </svg>
            </button>
        </div>
    <?php endforeach; ?>

</div>

