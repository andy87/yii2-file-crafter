<?php

namespace andy87\yii2\file_crafter\test\models;

use andy87\yii2\file_crafter\test\UnitTestCore;
use andy87\yii2\file_crafter\components\models\Field;

/**
 * @cli vendor/bin/phpunit tests/models/FieldTest.php --testdox
 *
 * @package andy87\yii2\file_crafter\test\models
 *
 * @tag: #test #model #field
 */
class FieldTest extends UnitTestCore
{
    /** @var array  */
    private const DATA_FIELD = [
        Field::NAME => 'test',
        Field::COMMENT => 'test',
        Field::TYPE => 'int',
        Field::SIZE => 11,
        Field::FOREIGN_KEYS => true,
        Field::UNIQUE => true,
        Field::NOT_NULL => true,
    ];



    /**
     * @cli vendor/bin/phpunit tests/models/FieldTest.php --testdox --filter testField
     *
     * @return void
     */
    public function testField(): void
    {
        $field = new Field();

        $field->load(self::DATA_FIELD, '');

        $field->validate();

        foreach (self::DATA_FIELD as $key => $value) {
            $this->assertEquals($field->{$key}, $value);
        }

        $this->assertEmpty($field->errors);
    }
}