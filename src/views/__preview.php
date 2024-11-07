<?php

use yii\web\View;
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
<h5>Schema name: <?=$schema->name?> ( <?=$schema->table_name?> )</h5>

<h6>Custom fields: </h6>
<?php if (count($schema->custom_fields)): ?>
<ul>
    <?php foreach ($schema->custom_fields as $key => $value): ?>
        <li>{{<?= $key ?>}}: <?= $value ?></li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>

<?php elseif ( isset($table_name) ): ?>
<h5>Table name: <?=$table_name?></h5>
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
                <td><?= $field[Field::NAME] ?></td>
                <td><?= $field[Field::COMMENT] ?></td>
                <td><?= $field[Field::TYPE] ?></td>
                <td><?= $field[Field::SIZE] ?></td>
                <td><?= (isset($field[Field::FOREIGN_KEYS])) ? 'X' : '' ?></td>
                <td><?= (isset($field[Field::UNIQUE])) ? 'X' : '' ?></td>
                <td><?= (isset($field[Field::NOT_NULL])) ? 'X' : '' ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
