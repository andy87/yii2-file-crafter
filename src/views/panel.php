<?php declare(strict_types=1);

use yii\{ web\View, widgets\ActiveForm };
use andy87\yii2\file_crafter\{components\models\Schema, Crafter, components\assets\FileCrafterPanelAsset};

/**
 * @var View $this
 * @var ActiveForm $form
 * @var Crafter $generator
 */

FileCrafterPanelAsset::register($this);

?>

<?= \yii\helpers\Html::activeHiddenInput($generator, 'migrationTimestamp', [
    'value' => is_string($generator->migrationTimestamp) ? $generator->migrationTimestamp : '',
]) ?>
<?= \yii\helpers\Html::errorSummary($generator) ?>

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

<?= $this->render('cache'. DIRECTORY_SEPARATOR .'tr', ['generator' => $generator ] );?>

<div id="errorWrapper">
    <?php if (isset($generator->panelResources->schema->errors[Schema::TEMPLATE])): ?>
        <?= $form->field( $generator->panelResources->schema, Schema::TEMPLATE, [
            'template' => '{input}{error}',
        ])->hiddenInput(['class' => 'input is-invalid'])->label(false);
        ?>
    <?php endif; ?>
</div>
