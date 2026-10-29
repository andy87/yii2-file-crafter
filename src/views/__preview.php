<?php declare(strict_types=1);

use yii\web\View;
use yii\helpers\Html;
use andy87\yii2\file_crafter\Crafter;
use andy87\yii2\file_crafter\components\models\Field;
use andy87\yii2\file_crafter\components\models\Schema;

/**
 * @var View $this
 * @var Crafter $generator
 * @var Schema $schema
 * @var string $table_name
 */

$fields = $fields ?? $schema->db_fields;

?>

<?php if ( isset($schema) ): ?>
<h5>Schema name: <?= Html::encode($schema->name) ?> ( <?= Html::encode($schema->table_name) ?> )</h5>

<h6>Custom fields: </h6>
<?php if (count($schema->custom_fields)): ?>
<ul>
    <?php foreach ($schema->custom_fields as $key => $value): ?>
        <li>{{<?= Html::encode($key) ?>}}: <?= Html::encode($value) ?></li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>

<?php elseif ( isset($table_name) ): ?>
<h5>Table name: <?= Html::encode($table_name) ?></h5>
<?php endif; ?>

<table class=table>
    <thead>
    <tr>
        <th>fieldName</th>
        <th>comment</th>
        <th>type</th>
        <th>size</th>
        <th>FK</th>
        <th>UN</th>
        <th>NN</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($fields as $field) : ?>
            <tr>
                <td><?= Html::encode($field[Field::NAME]) ?></td>
                <td><?= Html::encode($field[Field::COMMENT]) ?></td>
                <td><?= Html::encode($field[Field::TYPE]) ?></td>
                <td><?= Html::encode($field[Field::SIZE]) ?></td>
                <td><?= (!empty($field[Field::FOREIGN_KEYS])) ? 'X' : '' ?></td>
                <td><?= (!empty($field[Field::UNIQUE])) ? 'X' : '' ?></td>
                <td><?= (!empty($field[Field::NOT_NULL])) ? 'X' : '' ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
