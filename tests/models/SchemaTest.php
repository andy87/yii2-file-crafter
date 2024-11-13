<?php declare(strict_types=1);

namespace andy87\yii2\file_crafter\tests\models;

use PHPUnit\Framework\TestCase;
use andy87\yii2\file_crafter\components\models\Field;
use andy87\yii2\file_crafter\components\models\Schema;

/**
 * @cli vendor/bin/phpunit tests/models/SchemaTest.php --testdox
 *
 * @package andy87\yii2\file_crafter\tests\models
 *
 * @tag: #test #model #schema
 */
class SchemaTest extends TestCase
{
    /** @var array  */
    private const DATA_SCHEMA = [
        Schema::NAME => 'test',
        Schema::TABLE_NAME => 'test',
        Schema::DB_FIELDS => [
            [
                Field::NAME => 'test',
                Field::COMMENT => 'test',
                Field::TYPE => 'int',
                Field::SIZE => 11,
                Field::FOREIGN_KEYS => true,
                Field::UNIQUE => true,
                Field::NOT_NULL => true,
            ],
        ],
    ];



    /**
     * @cli vendor/bin/phpunit tests/models/SchemaTest.php --testdox --filter testSchema
     *
     * @return void
     */
    public function testSchema(): void
    {
        $schema = new Schema();

        $schema->load(self::DATA_SCHEMA, '');

        $schema->validate();

        foreach (self::DATA_SCHEMA as $key => $value) {
            $this->assertEquals($schema->{$key}, $value);
        }

        $this->assertEmpty($schema->errors);
    }
}