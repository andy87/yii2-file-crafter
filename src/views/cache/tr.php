<?php

use andy87\yii2\dnk_file_crafter\components\models\DbFieldDto;
use yii\web\View;
use andy87\yii2\dnk_file_crafter\Crafter;

/**
 * @var View $this
 * @var Crafter $generator
 */

$R = $generator->panelResources;

?>

<script type="text/html" id="template_db_field">

    <tr class="b_field--row">

        <td class="b_field--cell" data-db-field="<?= DbFieldDto::ATTR_NAME ?>">
            <input class=input type="text" name="<?= $R->tableInfoDto::ATTR_DB_FIELDS ?>[0][<?= DbFieldDto::ATTR_NAME ?>]">
        </td>

        <td class="b_field--cell" data-db-field="<?= DbFieldDto::ATTR_COMMENT ?>">
            <input class="input" type="text" name="<?= $R->tableInfoDto::ATTR_DB_FIELDS ?>[0][<?= DbFieldDto::ATTR_COMMENT ?>]">
        </td>

        <td class="b_field--cell" data-db-field="<?= DbFieldDto::ATTR_TYPE ?>">
            <select class="input" name="<?= $R->tableInfoDto::ATTR_DB_FIELDS ?>[0][<?= DbFieldDto::ATTR_TYPE ?>]">
                <?php foreach ( $R->tableInfoDto::TYPES as $key => $value ) : ?>
                    <option value="<?= $key?>"><?= $value?></option>
                <?php endforeach; ?>
            </select>
        </td>

        <td class="b_field--cell" data-db-field="<?= DbFieldDto::ATTR_SIZE ?>">
            <input class="input" type="number" name="<?= $R->tableInfoDto::ATTR_DB_FIELDS ?>[0][<?= DbFieldDto::ATTR_SIZE ?>]">
        </td>

        <td class="b_field--cell __mini" data-db-field="<?= DbFieldDto::ATTR_FOREIGN_KEYS ?>">
            <input class="b_form--checkbox" type="checkbox" name="<?= $R->tableInfoDto::ATTR_DB_FIELDS ?>[0][<?= DbFieldDto::ATTR_FOREIGN_KEYS ?>]" title="Foreign Key">
        </td>

        <td class="b_field--cell __mini" data-db-field="<?= DbFieldDto::ATTR_UNIQUE ?>">
            <input class="b_form--checkbox" type="checkbox" name="<?= $R->tableInfoDto::ATTR_DB_FIELDS ?>[0][<?= DbFieldDto::ATTR_UNIQUE ?>]" title="Unique">
        </td>

        <td class="b_field--cell __mini" data-db-field="<?= DbFieldDto::ATTR_NOT_NULL ?>">
            <input class="b_form--checkbox" type="checkbox" name="<?= $R->tableInfoDto::ATTR_DB_FIELDS ?>[0][<?= DbFieldDto::ATTR_NOT_NULL ?>]" title="Not Null">
        </td>

        <td class="b_field--cell __btn">
            <button class="b_field--button __removeField" onclick="app.actions.removeField(this)" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#FF0000" width="20px" height="20px" viewBox="0 0 32 32">
                    <path d="M0 26.016q0 2.496 1.76 4.224t4.256 1.76h20q2.464 0 4.224-1.76t1.76-4.224v-20q0-2.496-1.76-4.256t-4.224-1.76h-20q-2.496 0-4.256 1.76t-1.76 4.256v20zM4 26.016v-20q0-0.832 0.576-1.408t1.44-0.608h20q0.8 0 1.408 0.608t0.576 1.408v20q0 0.832-0.576 1.408t-1.408 0.576h-20q-0.832 0-1.44-0.576t-0.576-1.408zM8 16q0 0.832 0.576 1.44t1.44 0.576h12q0.8 0 1.408-0.576t0.576-1.44-0.576-1.408-1.408-0.576h-12q-0.832 0-1.44 0.576t-0.576 1.408z"/>
                </svg>
            </button>
        </td>
    </tr>

</script>