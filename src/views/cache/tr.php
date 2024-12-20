<?php declare(strict_types=1);

use yii\web\View;
use andy87\yii2\file_crafter\Crafter;
use andy87\yii2\file_crafter\components\models\{ Field, Schema };

/**
 * @var View $this
 * @var Crafter $generator
 */

$R = $generator->panelResources;

$prefix = Schema::DB_FIELDS . '[0]';

?>

<script type="text/html" id="template_db_field">

    <tr class="b_field--row __new">

        <td class="b_field--cell" data-db-field="<?= Field::NAME ?>">
            <label>
                <input class=input type="text"
                       onchange="app.dbFields.changeKey(this)"
                       data-key="[0]"
                       name="<?= $prefix ?>[<?= Field::NAME ?>]">
            </label>
        </td>

        <td class="b_field--cell" data-db-field="<?= Field::COMMENT ?>">
            <labeL>
                <input class="input" type="text" name="<?= $prefix ?>[<?= Field::COMMENT ?>]">
            </labeL>
        </td>

        <td class="b_field--cell" data-db-field="<?= Field::TYPE ?>">
            <label>
                <select class="input" name="<?= $prefix ?>[<?= Field::TYPE ?>]">
                    <?php foreach (Field::TYPES as $key => $value ) : ?>
                        <option value="<?= $key?>"><?= $value?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </td>

        <td class="b_field--cell" data-db-field="<?= Field::SIZE ?>">
            <labeL>
                <input class="input" type="number" name="<?= $prefix ?>[<?= Field::SIZE ?>]">
            </labeL>
        </td>

        <td class="b_field--cell __mini" data-db-field="<?= Field::FOREIGN_KEYS ?>">
            <labeL>
                <input class="b_form--checkbox" type="checkbox" name="<?= $prefix ?>[<?= Field::FOREIGN_KEYS ?>]" title="Foreign Key">
            </labeL>
        </td>

        <td class="b_field--cell __mini" data-db-field="<?= Field::UNIQUE ?>">
            <labeL>
                <input class="b_form--checkbox" type="checkbox" name="<?= $prefix ?>[<?= Field::UNIQUE ?>]" title="Unique">
            </labeL>
        </td>

        <td class="b_field--cell __mini" data-db-field="<?= Field::NOT_NULL ?>">
            <labeL>
                <input class="b_form--checkbox" type="checkbox" name="<?= $prefix ?>[<?= Field::NOT_NULL ?>]" title="Not Null">
            </labeL>
        </td>

        <td class="b_field--cell __btn">
            <button class="b_field--button __removeField" onclick="app.dbFields.removeField(this)" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#FF0000" width="20px" height="20px" viewBox="0 0 32 32">
                    <path d="M0 26.016q0 2.496 1.76 4.224t4.256 1.76h20q2.464 0 4.224-1.76t1.76-4.224v-20q0-2.496-1.76-4.256t-4.224-1.76h-20q-2.496 0-4.256 1.76t-1.76 4.256v20zM4 26.016v-20q0-0.832 0.576-1.408t1.44-0.608h20q0.8 0 1.408 0.608t0.576 1.408v20q0 0.832-0.576 1.408t-1.408 0.576h-20q-0.832 0-1.44-0.576t-0.576-1.408zM8 16q0 0.832 0.576 1.44t1.44 0.576h12q0.8 0 1.408-0.576t0.576-1.44-0.576-1.408-1.408-0.576h-12q-0.832 0-1.44 0.576t-0.576 1.408z"/>
                </svg>
            </button>
        </td>
    </tr>

</script>