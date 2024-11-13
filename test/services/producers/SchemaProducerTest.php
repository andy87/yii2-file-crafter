<?php

namespace andy87\yii2\file_crafter\test\services\producers;

use andy87\yii2\file_crafter\test\UnitTestCore;
use andy87\yii2\file_crafter\components\models\Schema;
use andy87\yii2\file_crafter\components\services\producers\SchemaProducer;

/**
 * @cli vendor/bin/phpunit tests/services/producers/SchemaProducerTest.php --testdox
 *
 * @package andy87\yii2\file_crafter\test\services\producers
 *
 * @tag: #test #service #producer #schema_producer
 */
class SchemaProducerTest extends UnitTestCore
{
    /** @var array  */
    private const CUSTOM_FIELDS = [
        'test' => 'test',
        'test2' => 'test2',
    ];

    /**
     * @cli vendor/bin/phpunit tests/services/producers/SchemaProducerTest.php --testdox --filter testSchemaProducerCreate
     *
     * @return void
     */
    public function testSchemaProducerCreate(): void
    {
        $schemaProducer = new SchemaProducer(self::CUSTOM_FIELDS);

        $schema = $schemaProducer->create();

        $this->assertInstanceof(Schema::class, $schema);

        $this->assertEquals(array_keys($schema->custom_fields), array_keys(self::CUSTOM_FIELDS));

        $schema = $schemaProducer->create([
            Schema::NAME => 'Test Two',
        ]);

        $this->assertEquals('Test Two', $schema->name);
        $this->assertEquals('test_two', $schema->table_name);
    }

    /**
     * @cli vendor/bin/phpunit tests/services/producers/SchemaProducerTest.php --testdox --filter testSchemaProducerCreateParseDb
     *
     * @return void
     */
    public function testSchemaProducerCreateParseDb(): void
    {
        $schemaProducer = new SchemaProducer(self::CUSTOM_FIELDS);

        $schema = $schemaProducer->createParseDb();

        $this->assertEquals(Schema::SCENARIO_PARSE_DB, $schema->scenario);
    }
}