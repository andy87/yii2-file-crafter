<?php

use yii\web\View;
use andy87\yii2\file_crafter\Crafter;
use andy87\yii2\file_crafter\components\models\{ Field, Schema };

/**
 * @var View $this
 * @var Crafter $generator
 */

$R = $generator->panelResources;

$customFields = $generator->custom_fields;
$listDbFields = $R->schema->getDbFields();
?>

<div class="block__form">
    <div class="b_form--wrapper">

        <label class="b_form--label __main">
            <?= $R->schema->getAttributeLabel(Schema::TABLE_NAME); ?>
            <br>
            <svg xmlns="http://www.w3.org/2000/svg" fill="#000" width="32px" height="32px" viewBox="0 0 32 32">
                <path d="M0 26.016q0 2.496 1.76 4.224t4.256 1.76h20q2.464 0 4.224-1.76t1.76-4.224v-20q0-2.496-1.76-4.256t-4.224-1.76h-20q-2.496 0-4.256 1.76t-1.76 4.256v20zM4 26.016v-20q0-0.832 0.576-1.408t1.44-0.608h20q0.8 0 1.408 0.608t0.576 1.408v20q0 0.832-0.576 1.408t-1.408 0.576h-20q-0.832 0-1.44-0.576t-0.576-1.408zM6.016 16q0 0.832 0.576 1.44t1.408 0.576v1.984q0 2.496 1.76 4.256t4.256 1.76v-4q-0.832 0-1.44-0.576t-0.576-1.44v-1.984q-0.832 0-1.408-0.576t-0.576-1.44 0.576-1.408 1.408-0.576v-2.016q0-0.832 0.576-1.408t1.44-0.576v-4q-2.496 0-4.256 1.76t-1.76 4.224v2.016q-0.832 0-1.408 0.576t-0.576 1.408zM18.016 26.016q2.464 0 4.224-1.76t1.76-4.256v-1.984q0.832 0 1.408-0.576t0.608-1.44-0.608-1.408-1.408-0.576v-2.016q0-2.464-1.76-4.224t-4.224-1.76v4q0.8 0 1.408 0.576t0.576 1.408v2.016q0.832 0 1.408 0.576t0.608 1.408-0.608 1.44-1.408 0.576v1.984q0 0.832-0.576 1.44t-1.408 0.576v4z"/>
            </svg>
            <input class="input __header" type="text" name="<?= Schema::NAME?>" value="<?= $R->schema->getName() ?>">
        </label>

    </div>

    <?php if( count($customFields) ): ?>
        <div class="b_form--wrapper">
            <b class="b_form--label __main">Custom fields</b>
            <?php foreach ($customFields as $fieldKey => $fieldLabel) : ?>
                <div class="b_form--layer">
                    <label class="b_form--label" for="<?= $fieldKey?>"><?= $fieldLabel?></label>
                    <input class="input" type="text"
                           title="{{<?= $fieldKey?>}}"
                           name="<?= Schema::CUSTOM_FIELDS ."[$fieldKey]"?>"
                           value="<?= (count($R->schema->getCustomFields())) ? $R->schema->custom_fields[$fieldKey] : '' ?>">
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="block__field">
        <h4 class="header">
            <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" width="32px" height="32px" viewBox="0 0 32 32">
                <path d="M4 26.016q0 1.632 1.6 3.008t4.384 2.176 6.016 0.8q0.128 0 0.352 0t0.32-0.032q-2.24-1.568-3.488-4.096-4.064-0.384-6.624-1.792t-2.56-3.456v3.392zM4 20q0 1.984 2.336 3.552t6.048 2.144q-0.384-1.472-0.384-2.688 0-0.096 0.128-1.28-3.648-0.512-5.888-1.824t-2.24-3.264v3.36zM4 14.016q0 2.016 2.4 3.584t6.176 2.144q0.64-2.112 2.048-3.776-3.008-0.128-5.408-0.8t-3.808-1.856-1.408-2.688v3.392zM4 8q0 1.632 1.6 3.008t4.384 2.208 6.016 0.8q0.128 0 0.384-0.032t0.352 0q2.848-1.984 6.272-1.984 0.544 0 1.632 0.16 1.568-0.832 2.464-1.888t0.896-2.272v-1.984q0-1.632-1.6-3.008t-4.384-2.176-6.016-0.832-6.016 0.832-4.384 2.176-1.6 3.008v1.984zM14.016 23.008q0 2.432 1.184 4.512t3.296 3.296 4.512 1.216 4.512-1.216 3.264-3.296 1.216-4.512q0-1.824-0.704-3.488t-1.92-2.88-2.88-1.92-3.488-0.704-3.488 0.704-2.88 1.92-1.92 2.88-0.704 3.488zM18.016 23.008q0-2.080 1.44-3.52t3.552-1.472 3.52 1.472 1.472 3.52-1.472 3.552-3.52 1.44-3.552-1.44-1.44-3.552zM20 24h2.016v2.016h1.984v-2.016h2.016v-1.984h-2.016v-2.016h-1.984v2.016h-2.016v1.984zM27.104 12.832q0.192 0.064 0.896 0.448v-2.656q0 1.216-0.896 2.208z"/>
            </svg>
            Attributes
        </h4>
        <table class="b_field--table">
            <thead class="b_field--layer">
            <tr class="b_field--row">
                <th class="b_field--header">
                    name
                </th>
                <th class="b_field--header">comment</th>
                <th class="b_field--header __type">type</th>
                <th class="b_field--header __size">size</th>
                <th class="b_field--header __mini" title="Foreign Key">FK</th>
                <th class="b_field--header __mini" title="Unique">UN</th>
                <th class="b_field--header __mini" title="Not Null">NN</th>
                <th class="b_field--header __btn">
                    <button class="b_field--button __addField" onclick="app.dbFields.addField(this)" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#009900" width="20px" height="20px" viewBox="0 0 32 32">
                            <path d="M0 26.016q0 2.496 1.76 4.224t4.256 1.76h20q2.464 0 4.224-1.76t1.76-4.224v-20q0-2.496-1.76-4.256t-4.224-1.76h-20q-2.496 0-4.256 1.76t-1.76 4.256v20zM4 26.016v-20q0-0.832 0.576-1.408t1.44-0.608h20q0.8 0 1.408 0.608t0.576 1.408v20q0 0.832-0.576 1.408t-1.408 0.576h-20q-0.832 0-1.44-0.576t-0.576-1.408zM8 16q0 0.832 0.576 1.44t1.44 0.576h4v4q0 0.832 0.576 1.408t1.408 0.576 1.408-0.576 0.608-1.408v-4h4q0.8 0 1.408-0.576t0.576-1.44-0.576-1.408-1.408-0.576h-4v-4q0-0.832-0.608-1.408t-1.408-0.608-1.408 0.608-0.576 1.408v4h-4q-0.832 0-1.44 0.576t-0.576 1.408z"/>
                        </svg>
                    </button>
                </th>
            </tr>
            </thead>
            <tbody class="b_field--layer" id="table_db_field">
                <?php if( count($listDbFields) ): ?>
                    <?php foreach ($listDbFields as $dbField) :
                        $prefix = Schema::DB_FIELDS . '[' . $dbField[Field::NAME] . ']';
                        ?>
                        <tr class="b_field--row">

                            <td class="b_field--cell" data-db-field="<?= Field::NAME ?>">
                                <labeL>
                                    <input class=input type="text"
                                           onchange="app.dbFields.changeKey(this)"
                                           data-key="<?= $dbField[Field::NAME] ?>"
                                           name="<?= $prefix ?>[<?= Field::NAME ?>]"
                                           value="<?= $dbField[Field::NAME] ?? '' ?>">
                                    </labeL>
                            </td>

                            <td class="b_field--cell" data-db-field="<?= Field::COMMENT ?>">
                                <label>
                                    <input class="input" type="text"
                                           name="<?= $prefix ?>[<?= Field::COMMENT ?>]"
                                           value="<?= $dbField[Field::COMMENT] ?? '' ?>">
                                </label>
                            </td>

                            <td class="b_field--cell" data-db-field="<?= Field::TYPE ?>">
                                <?php $option = $dbField[Field::TYPE] ?>
                               <label>
                                   <select class="input" name="<?= $prefix ?>[<?= Field::TYPE ?>]">
                                       <?php foreach (Field::TYPES as $key => $value ) : ?>
                                           <option value="<?= $key?>" <?= ($option === $key) ? 'selected' : '' ?>><?= $value?></option>
                                       <?php endforeach; ?>
                                   </select>
                               </label>
                            </td>

                            <td class="b_field--cell" data-db-field="<?= Field::SIZE ?>">
                                <label>
                                    <input class="input" type="number"
                                           name="<?= $prefix ?>[<?= Field::SIZE ?>]"
                                           value="<?= $dbField[Field::SIZE] ?? '' ?>">
                                </label>
                            </td>

                            <td class="b_field--cell __mini" data-db-field="<?= Field::FOREIGN_KEYS ?>">
                                <label>
                                    <input class="b_form--checkbox" type="checkbox" title="Foreign Key"
                                           name="<?= $prefix ?>[<?= Field::FOREIGN_KEYS ?>]"
                                        <?= $dbField[Field::FOREIGN_KEYS] ?? '' ?>>
                                </label>
                            </td>

                            <td class="b_field--cell __mini" data-db-field="<?= Field::UNIQUE ?>">
                                <label>
                                    <input class="b_form--checkbox" type="checkbox" title="Unique"
                                       name="<?= $prefix ?>[<?= Field::UNIQUE ?>]"
                                    <?= $dbField[Field::UNIQUE] ?? '' ?>>
                                </label>
                            </td>

                            <td class="b_field--cell __mini" data-db-field="<?= Field::NOT_NULL ?>">
                                <label>
                                    <input class="b_form--checkbox" type="checkbox" title="Not Null"
                                       name="<?= $prefix ?>[<?= Field::NOT_NULL ?>]"
                                    <?= $dbField[Field::NOT_NULL] ?? '' ?>>
                                </label>
                            </td>

                            <td class="b_field--cell __btn">
                                <button class="b_field--button __removeField" onclick="app.dbFields.removeField(this)" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="#FF0000" width="20px" height="20px" viewBox="0 0 32 32">
                                        <path d="M0 26.016q0 2.496 1.76 4.224t4.256 1.76h20q2.464 0 4.224-1.76t1.76-4.224v-20q0-2.496-1.76-4.256t-4.224-1.76h-20q-2.496 0-4.256 1.76t-1.76 4.256v20zM4 26.016v-20q0-0.832 0.576-1.408t1.44-0.608h20q0.8 0 1.408 0.608t0.576 1.408v20q0 0.832-0.576 1.408t-1.408 0.576h-20q-0.832 0-1.44-0.576t-0.576-1.408zM8 16q0 0.832 0.576 1.44t1.44 0.576h12q0.8 0 1.408-0.576t0.576-1.44-0.576-1.408-1.408-0.576h-12q-0.832 0-1.44 0.576t-0.576 1.408z"/>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="form-group text-right pt-3">
        <?php if ( $R->schema->isCreate() ) : ?>
            <button type="submit" class="btn btn-success" name="<?= Schema::SCENARIO_CREATE ?>">Create</button>
        <?php else : ?>
            <a href="?" class="btn btn-warning">Close</a>
            <button type="submit" class="btn btn-info" name="<?= Schema::SCENARIO_UPDATE?>">Save</button>
        <?php endif; ?>
    </div>
</div>